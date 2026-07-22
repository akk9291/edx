<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /**
     * Send OTP to email
     */
    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $email = $request->email;
        $otp = rand(100000, 999999);
        $expiresAt = now()->addMinutes(5);

        // Store OTP in cache
        Cache::put("otp_{$email}", $otp, $expiresAt);

        // Send OTP email (implementation depends on your mail service)
        try {
            Mail::raw("Your OTP is: {$otp}. Valid for 5 minutes.", function ($message) use ($email) {
                $message->to($email)
                    ->subject('Your OTP Code');
            });
        } catch (\Exception $e) {
            // Log error but don't fail the request
            \Log::error('OTP email failed: ' . $e->getMessage());
        }

        return response()->json([
            'success' => true,
            'message' => 'OTP sent to your email',
        ]);
    }

    /**
     * Verify OTP and login
     */
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|numeric',
        ]);

        $email = $request->email;
        $otp = $request->otp;

        // Check OTP
        $storedOtp = Cache::get("otp_{$email}");

        if (!$storedOtp || $storedOtp != $otp) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid OTP',
            ], 400);
        }

        // Clear OTP
        Cache::forget("otp_{$email}");

        // Find or create user
        $user = User::firstOrCreate(
            ['email' => $email],
            [
                'name' => explode('@', $email)[0],
                'password' => Hash::make(Str::random(16)),
                'is_admin' => false,
            ]
        );

        // Create token
        $token = $user->createToken('auth-token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login successful',
            'data' => [
                'user' => $user,
                'token' => $token,
            ],
        ]);
    }

    /**
     * Customer registration
     */
    public function register(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|max:20|unique:users,phone',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'name' => $request->first_name . ' ' . $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'is_admin' => false,
        ]);

        $token = $user->createToken('customer-token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Registration successful',
            'data' => [
                'user' => $user,
                'token' => $token,
            ],
        ], 201);
    }

    /**
     * Customer login (email/phone + password)
     */
    public function customerLogin(Request $request)
    {
        $request->validate([
            'email' => 'required_without:phone|email',
            'phone' => 'required_without:email|string',
            'password' => 'required|string',
        ]);

        $user = null;

        if ($request->email) {
            $user = User::where('email', $request->email)->first();
        } elseif ($request->phone) {
            $user = User::where('phone', $request->phone)->first();
        }

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid credentials',
            ], 401);
        }

        // Check if admin trying to login via customer endpoint
        if ($user->isAdmin()) {
            return response()->json([
                'success' => false,
                'message' => 'Please use admin login endpoint',
            ], 403);
        }

        // Sync guest cart on login
        $this->syncGuestCart($request, $user);

        $token = $user->createToken('customer-token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login successful',
            'data' => [
                'user' => $user,
                'token' => $token,
            ],
        ]);
    }

    /**
     * Admin login (email + password)
     */
    public function adminLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid credentials',
            ], 401);
        }

        if (!$user->isAdmin()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized. Admin access required.',
            ], 403);
        }

        $token = $user->createToken('admin-token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Admin login successful',
            'data' => [
                'user' => $user,
                'token' => $token,
            ],
        ]);
    }

    /**
     * Get authenticated user
     */
    public function user(Request $request)
    {
        return response()->json([
            'success' => true,
            'data' => $request->user(),
        ]);
    }

    /**
     * Update profile
     */
    public function updateProfile(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'first_name' => 'sometimes|required|string|max:255',
            'last_name' => 'sometimes|required|string|max:255',
            'phone' => 'sometimes|nullable|string|max:20|unique:users,phone,' . $user->id,
        ]);

        $user->update($request->only(['first_name', 'last_name', 'phone']));

        if ($request->has('first_name') || $request->has('last_name')) {
            $user->name = ($user->first_name ?? '') . ' ' . ($user->last_name ?? '');
            $user->save();
        }

        return response()->json([
            'success' => true,
            'message' => 'Profile updated successfully',
            'data' => $user->fresh(),
        ]);
    }

    /**
     * Logout
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logged out successfully',
        ]);
    }

    /**
     * Forgot password - send OTP
     */
    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user->isAdmin()) {
            return response()->json([
                'success' => false,
                'message' => 'OTP password reset is not available for admin accounts',
            ], 403);
        }

        $otp = rand(100000, 999999);
        $expiresAt = now()->addMinutes(5);

        Cache::put("password_reset_otp_{$request->email}", $otp, $expiresAt);

        $mailSent = false;
        try {
            Mail::raw("Your password reset OTP is: {$otp}. Valid for 5 minutes.", function ($message) use ($request) {
                $message->to($request->email)
                    ->subject('Password Reset OTP');
            });
            $mailSent = true;
        } catch (\Exception $e) {
            \Log::error('Password reset OTP email failed: ' . $e->getMessage());
        }

        $message = 'Password reset OTP sent to your email.';
        if (!$mailSent && config('app.debug')) {
            $message .= ' (Email failed - use OTP for testing: ' . $otp . ')';
        }

        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $mailSent ? [] : (config('app.debug') ? ['otp' => $otp] : []),
        ]);
    }

    /**
     * Reset password with OTP
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'otp' => 'required|numeric',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user->isAdmin()) {
            return response()->json([
                'success' => false,
                'message' => 'OTP password reset is not available for admin accounts',
            ], 403);
        }

        // Check OTP
        $storedOtp = Cache::get("password_reset_otp_{$request->email}");

        if (!$storedOtp || $storedOtp != $request->otp) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid OTP',
            ], 400);
        }

        // Clear OTP
        Cache::forget("password_reset_otp_{$request->email}");

        // Update password
        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Password reset successful',
        ]);
    }

    /**
     * Sync guest cart with user cart on login
     */
    private function syncGuestCart(Request $request, User $user)
    {
        $sessionId = $request->cookie('cart_session_id');
        
        if ($sessionId) {
            $guestCartItems = \App\Models\Cart::where('session_id', $sessionId)->get();
            
            foreach ($guestCartItems as $cartItem) {
                // Check if user already has this product in cart
                $existingCart = \App\Models\Cart::where('user_id', $user->id)
                    ->where('product_id', $cartItem->product_id)
                    ->where('size', $cartItem->size)
                    ->where('color', $cartItem->color)
                    ->first();

                if ($existingCart) {
                    // Update quantity
                    $existingCart->quantity += $cartItem->quantity;
                    $existingCart->save();
                    $cartItem->delete();
                } else {
                    // Transfer to user
                    $cartItem->user_id = $user->id;
                    $cartItem->session_id = null;
                    $cartItem->save();
                }
            }
        }
    }
}




