<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\OTPService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class MobileAuthController extends Controller
{
    private $otpService;

    public function __construct(OTPService $otpService)
    {
        $this->otpService = $otpService;
    }

    private function autoEmailFromMobile(string $mobile): string
    {
        // Email column is non-nullable in this project, so OTP registration always needs an email.
        // If client doesn't provide email, generate a deterministic one from mobile.
        return "c_{$mobile}@otp.supertops.local";
    }

    private function normalizeMobile(string $mobile): string
    {
        return preg_replace('/\s+/', '', $mobile);
    }

    /**
     * Send OTP for registration
     */
    public function sendRegistrationOTP(Request $request)
    {
        $payload = $request->all();
        // If email exists but is empty, treat it as not provided.
        if (array_key_exists('email', $payload) && trim((string) $payload['email']) === '') {
            unset($payload['email']);
        }

        $validator = Validator::make($payload, [
            'mobile' => 'required|digits:10|regex:/^[6-9]\d{9}$/',
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            \Log::info('Registration OTP validation failed:', [
                'request_data' => $payload,
                'errors' => $validator->errors()->toArray()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 400);
        }

        $mobile = $this->normalizeMobile((string) $payload['mobile']);
        
        // Check if mobile number already exists (check both formats)
        $existingUser = \App\Models\User::where('phone', $mobile)
                                        ->orWhere('phone', '+91' . $mobile)
                                        ->first();
        
        if ($existingUser) {
            return response()->json([
                'success' => false,
                'message' => 'Mobile number is already registered. Please use login instead.',
                'errors' => ['mobile' => ['This mobile number is already registered']]
            ], 400);
        }

        $email = isset($payload['email']) ? (string) $payload['email'] : '';
        $email = $email !== '' ? $email : $this->autoEmailFromMobile($mobile);
        
        try {
            $result = $this->otpService->sendOTP($mobile);

            if ($result['success']) {
                // Store registration data temporarily
                $registrationData = [
                    'name' => (string) $payload['name'],
                    'mobile' => $mobile,
                    'email' => $email,
                    'password' => Hash::make((string) $payload['password']),
                ];
                
                cache()->put("registration_data_" . $mobile, $registrationData, 600); // 10 minutes
                
                \Log::info('Registration OTP sent successfully:', [
                    'mobile' => $mobile,
                    'has_test_otp' => isset($result['otp'])
                ]);
            } else {
                \Log::error('Failed to send registration OTP:', [
                    'mobile' => $mobile,
                    'error' => $result
                ]);
            }

            return response()->json($result);
            
        } catch (\Exception $e) {
            \Log::error('Registration OTP send error:', [
                'mobile' => $mobile,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to send OTP due to system error. Please try again.',
                'error' => 'System error occurred'
            ], 500);
        }
    }

    /**
     * Verify OTP and complete registration
     */
    public function verifyAndRegister(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile' => 'required|digits:10|regex:/^[6-9]\d{9}$/',
            'otp' => 'required|digits:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid input',
                'errors' => $validator->errors()
            ], 400);
        }

        $mobile = $this->normalizeMobile((string) $request->mobile);
        $otp = $request->otp;

        // Verify OTP
        $otpResult = $this->otpService->verifyOTP($mobile, $otp);

        if (!$otpResult['success']) {
            return response()->json($otpResult);
        }

        // Get registration data from cache
        $registrationData = cache()->get("registration_data_" . $mobile);
        
        if (!$registrationData) {
            return response()->json([
                'success' => false,
                'message' => 'Registration session expired. Please start again.'
            ], 400);
        }

        try {
            // Guard: avoid duplicate creation on retries / race conditions.
            $alreadyRegistered = \App\Models\User::where('phone', $mobile)
                ->orWhere('phone', '+91' . $mobile)
                ->exists();
            if ($alreadyRegistered) {
                cache()->forget("registration_data_" . $mobile);
                return response()->json([
                    'success' => false,
                    'message' => 'Mobile number is already registered. Please use login instead.'
                ], 400);
            }

            $email = !empty($registrationData['email'])
                ? (string) $registrationData['email']
                : $this->autoEmailFromMobile($mobile);

            // Create user
            $user = User::create([
                'name' => (string) $registrationData['name'],
                'email' => $email,
                'phone' => $mobile,
                'password' => $registrationData['password'],
                'phone_verified_at' => now(),
            ]);

            // Clear registration data from cache
            cache()->forget("registration_data_" . $mobile);

            // Log the user in using Laravel's Auth system (for web session)
            Auth::login($user, true); // true = remember me

            // Generate token for API access
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'success' => true,
                'message' => 'Registration successful',
                'user' => $user,
                'token' => $token,
                'redirect_url' => route('my-account'),
                'welcome_message' => 'Welcome, ' . $user->name . '! Your account has been created successfully.'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Registration failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Send OTP for login
     */
    public function sendLoginOTP(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile' => 'required|digits:10|regex:/^[6-9]\d{9}$/',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid mobile number',
                'errors' => $validator->errors()
            ], 400);
        }

        $mobile = $request->mobile;

        // Check if user exists (check both formats)
        $user = User::where('phone', $mobile)
                   ->orWhere('phone', '+91' . $mobile)
                   ->first();
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Mobile number not registered. Please register first.'
            ], 404);
        }

        try {
            $result = $this->otpService->sendOTP($mobile);
            
            if ($result['success']) {
                \Log::info('Login OTP sent successfully:', [
                    'mobile' => $mobile,
                    'user_id' => $user->id,
                    'has_test_otp' => isset($result['otp'])
                ]);
            } else {
                \Log::error('Failed to send login OTP:', [
                    'mobile' => $mobile,
                    'user_id' => $user->id,
                    'error' => $result
                ]);
            }
            
            return response()->json($result);
            
        } catch (\Exception $e) {
            \Log::error('Login OTP send error:', [
                'mobile' => $mobile,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to send OTP due to system error. Please try again.',
                'error' => 'System error occurred'
            ], 500);
        }
    }

    /**
     * Verify OTP and login
     */
    public function verifyAndLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile' => 'required|digits:10|regex:/^[6-9]\d{9}$/',
            'otp' => 'required|digits:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid input',
                'errors' => $validator->errors()
            ], 400);
        }

        $mobile = $request->mobile;
        $otp = $request->otp;

        // Check if user exists (check both formats: '8839507322' and '+918839507322')
        $user = User::where('phone', $mobile)
                   ->orWhere('phone', '+91' . $mobile)
                   ->first();
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Mobile number not registered. Please register first.'
            ], 404);
        }

        // Verify OTP
        $otpResult = $this->otpService->verifyOTP($mobile, $otp);

        if (!$otpResult['success']) {
            return response()->json($otpResult);
        }

        try {
            // Update phone verification if not already verified
            if (!$user->phone_verified_at) {
                $user->phone_verified_at = now();
                $user->save();
            }

            // Log the user in using Laravel's Auth system (for web session)
            \Auth::login($user, true); // true = remember me

            // Generate token for API access
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'success' => true,
                'message' => 'Login successful',
                'user' => $user,
                'token' => $token,
                'redirect_url' => route('my-account'),
                'login_success' => 'Welcome back! You have successfully logged in.'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Login failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Resend login OTP
     */
    public function resendLoginOTP(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile' => 'required|digits:10|regex:/^[6-9]\d{9}$/',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 400);
        }

        $mobile = $request->mobile;

        // Check if user exists (check both formats)
        $user = User::where('phone', $mobile)
                   ->orWhere('phone', '+91' . $mobile)
                   ->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Mobile number not registered. Please register first.'
            ], 400);
        }

        // Resend OTP using OTP Service
        $result = $this->otpService->resendOTP($mobile);

        if ($result['success']) {
            return response()->json([
                'success' => true,
                'message' => 'OTP sent successfully'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => $result['message']
            ], 400);
        }
    }
}