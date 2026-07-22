<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Razorpay\Api\Api as RazorpayApi;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    private $razorpay;

    public function __construct()
    {
        $key = config('services.razorpay.key');
        $secret = config('services.razorpay.secret');
        
        if ($key && $secret) {
            $this->razorpay = new RazorpayApi($key, $secret);
        }
    }

    /**
     * Create Razorpay order
     */
    public function createOrder(Request $request)
    {
        Log::info('Payment order creation request:', $request->all());
        
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'currency' => 'nullable|string|size:3',
        ]);

        $key = config('services.razorpay.key');
        $secret = config('services.razorpay.secret');
        
        Log::info('Razorpay config:', [
            'key_exists' => !empty($key),
            'secret_exists' => !empty($secret),
            'key_prefix' => substr($key, 0, 10) . '...'
        ]);

        if (!$this->razorpay) {
            Log::error('Razorpay API not initialized', [
                'key' => $key,
                'secret_length' => strlen($secret ?? '')
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Razorpay is not configured properly',
            ], 500);
        }

        try {
            $amount = $request->amount * 100; // Convert to paise
            $currency = $request->currency ?? 'INR';

            $razorpayOrder = $this->razorpay->order->create([
                'receipt' => 'receipt_' . time(),
                'amount' => $amount,
                'currency' => $currency,
            ]);

            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $razorpayOrder['id'], // Razorpay expects 'id' not 'order_id'
                    'order_id' => $razorpayOrder['id'],
                    'amount' => $amount, // Amount in paise for Razorpay
                    'amount_rupees' => $request->amount, // Amount in rupees for display
                    'currency' => $currency,
                    'key' => config('services.razorpay.key'),
                ],
            ]);
        } catch (\Exception $e) {
            Log::error('Razorpay order creation failed: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Payment order creation failed',
            ], 500);
        }
    }

    /**
     * Verify payment and create order
     */
    public function verify(Request $request)
    {
        $request->validate([
            'razorpay_order_id' => 'required|string',
            'razorpay_payment_id' => 'required|string',
            'razorpay_signature' => 'required|string',
            'order_data' => 'required|array', // Order creation data
        ]);

        $webhookSecret = config('services.razorpay.webhook_secret');

        // Verify signature
        $attributes = [
            'razorpay_order_id' => $request->razorpay_order_id,
            'razorpay_payment_id' => $request->razorpay_payment_id,
            'razorpay_signature' => $request->razorpay_signature,
        ];

        try {
            if ($this->razorpay) {
                $this->razorpay->utility->verifyPaymentSignature($attributes);
            } else {
                // Manual verification if API not available
                $generatedSignature = hash_hmac('sha256', $request->razorpay_order_id . '|' . $request->razorpay_payment_id, $webhookSecret);
                
                if ($generatedSignature !== $request->razorpay_signature) {
                    throw new \Exception('Invalid signature');
                }
            }

            // Note: Order creation should be handled separately
            // This endpoint is just for payment verification
            // The actual order creation should happen before payment
            
            return response()->json([
                'success' => true,
                'message' => 'Payment verified successfully',
                'data' => [
                    'razorpay_order_id' => $request->razorpay_order_id,
                    'razorpay_payment_id' => $request->razorpay_payment_id,
                ],
            ]);

        } catch (\Exception $e) {
            Log::error('Payment verification failed: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Payment verification failed: ' . $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Test Razorpay configuration
     */
    public function testConfig()
    {
        $key = config('services.razorpay.key');
        $secret = config('services.razorpay.secret');
        
        return response()->json([
            'success' => true,
            'data' => [
                'key_configured' => !empty($key),
                'secret_configured' => !empty($secret),
                'key_prefix' => $key ? substr($key, 0, 15) . '...' : null,
                'razorpay_initialized' => !is_null($this->razorpay)
            ]
        ]);
    }

    /**
     * Get payment status
     */
    public function status($orderId)
    {
        $order = Order::where('order_number', $orderId)
            ->orWhere('razorpay_order_id', $orderId)
            ->firstOrFail();

        return response()->json([
            'success' => true,
            'data' => [
                'order_number' => $order->order_number,
                'payment_status' => $order->payment_status,
                'razorpay_order_id' => $order->razorpay_order_id,
                'razorpay_payment_id' => $order->razorpay_payment_id,
            ],
        ]);
    }

    /**
     * Razorpay webhook handler
     */
    public function webhook(Request $request)
    {
        $webhookSecret = config('services.razorpay.webhook_secret');
        $webhookSignature = $request->header('X-Razorpay-Signature');

        $payload = $request->getContent();

        // Verify webhook signature
        $expectedSignature = hash_hmac('sha256', $payload, $webhookSecret);

        if ($expectedSignature !== $webhookSignature) {
            Log::warning('Invalid webhook signature');
            return response()->json(['success' => false], 400);
        }

        $event = $request->json('event');
        $payload = $request->json('payload');

        try {
            if ($event === 'payment.captured') {
                $paymentId = $payload['payment']['entity']['id'];
                $orderId = $payload['payment']['entity']['order_id'];

                $order = Order::where('razorpay_order_id', $orderId)->first();

                if ($order) {
                    $order->razorpay_payment_id = $paymentId;
                    $order->payment_status = 'paid';
                    $order->save();
                }
            } elseif ($event === 'payment.failed') {
                $orderId = $payload['payment']['entity']['order_id'];

                $order = Order::where('razorpay_order_id', $orderId)->first();

                if ($order) {
                    $order->payment_status = 'failed';
                    $order->save();
                }
            }

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error('Webhook processing failed: ' . $e->getMessage());
            return response()->json(['success' => false], 500);
        }
    }
}

