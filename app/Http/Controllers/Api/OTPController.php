<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\OTPService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OTPController extends Controller
{
    private $otpService;

    public function __construct(OTPService $otpService)
    {
        $this->otpService = $otpService;
    }

    /**
     * Send OTP to mobile number
     */
    public function sendOTP(Request $request)
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
        $result = $this->otpService->sendOTP($mobile);

        return response()->json($result);
    }

    /**
     * Verify OTP
     */
    public function verifyOTP(Request $request)
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
        
        $result = $this->otpService->verifyOTP($mobile, $otp);

        return response()->json($result);
    }

    /**
     * Resend OTP
     */
    public function resendOTP(Request $request)
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
        $result = $this->otpService->resendOTP($mobile);

        return response()->json($result);
    }

    /**
     * Check if mobile is verified
     */
    public function checkVerification(Request $request)
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
        $isVerified = $this->otpService->isMobileVerified($mobile);

        return response()->json([
            'success' => true,
            'verified' => $isVerified
        ]);
    }
}