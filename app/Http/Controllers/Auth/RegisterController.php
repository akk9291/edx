<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    /**
     * Handle user registration request.
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s]+$/'],
            'last_name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s]+$/'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['nullable', 'string', 'max:20', 'regex:/^[0-9+\-\s()]+$/', 'unique:users,phone'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'first_name.required' => 'First name is required.',
            'first_name.regex' => 'First name can only contain letters and spaces.',
            'last_name.required' => 'Last name is required.',
            'last_name.regex' => 'Last name can only contain letters and spaces.',
            'email.required' => 'Email address is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email is already registered.',
            'phone.regex' => 'Please enter a valid phone number.',
            'phone.unique' => 'This phone number is already registered.',
            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 8 characters.',
            'password.confirmed' => 'Password confirmation does not match.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('error', 'Please correct the errors below.');
        }

        // Auto-verify email (no verification required)
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'name' => $request->first_name . ' ' . $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'is_admin' => false,
            'email_verified_at' => now(), // Auto-verify email
        ]);

        // Email verification disabled - user is auto-verified
        // Login user
        Auth::login($user);

        $redirect = $request->get('redirect', route('home'));
        
        return redirect($redirect)
            ->with('success', 'Registration successful! You are now logged in.');
    }

    /**
     * Verify user email
     */
    public function verifyEmail($token)
    {
        $user = User::where('email_verification_token', $token)
            ->whereNull('email_verified_at')
            ->first();

        if (!$user) {
            return redirect()->route('login')
                ->with('error', 'Invalid or expired verification link.');
        }

        $user->email_verified_at = now();
        $user->email_verification_token = null;
        $user->save();

        Auth::login($user);

        return redirect()->route('home')
            ->with('success', 'Email verified successfully! Your account is now active.');
    }

    /**
     * Resend verification email
     */
    public function resendVerification(Request $request)
    {
        if (!$request->user()) {
            return back()->with('error', 'Please login first.');
        }

        $user = $request->user();

        if ($user->email_verified_at) {
            return back()->with('info', 'Your email is already verified.');
        }

        // Generate new verification token if doesn't exist
        if (!$user->email_verification_token) {
            $user->email_verification_token = Str::random(64);
            $user->save();
        }

        // Send verification email
        try {
            Mail::send('emails.verify-email', [
                'user' => $user,
                'verificationUrl' => route('email.verify', ['token' => $user->email_verification_token])
            ], function ($message) use ($user) {
                $message->to($user->email, $user->name)
                    ->subject('Verify Your Email Address - ' . config('app.name'));
            });

            \Log::info('Resend verification email sent successfully to: ' . $user->email);
            return back()->with('success', 'Verification email sent! Please check your inbox.');
        } catch (\Exception $e) {
            $errorMessage = $e->getMessage();
            \Log::error('Resend verification email failed for user: ' . $user->email);
            \Log::error('Error details: ' . $errorMessage);
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            return back()->with('error', 'Failed to send verification email: ' . $errorMessage . '. Please check your email configuration in .env file.');
        }
    }
}

