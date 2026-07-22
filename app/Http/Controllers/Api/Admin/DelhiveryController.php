<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class DelhiveryController extends Controller
{
    private $endpoint;
    private $clientId;
    private $clientSecret;

    public function __construct()
    {
        $this->endpoint = config('services.delhivery.api_endpoint');
        $this->clientId = config('services.delhivery.client_id');
        $this->clientSecret = config('services.delhivery.client_secret');
    }

    /**
     * Create shipment for order
     */
    public function createShipment(Request $request, $id)
    {
        $order = Order::with(['user', 'items.product'])->findOrFail($id);

        if (!$this->endpoint || !$this->clientId || !$this->clientSecret) {
            return response()->json([
                'success' => false,
                'message' => 'Delhivery is not configured',
            ], 500);
        }

        $shippingAddress = $order->shipping_address;

        if (!$shippingAddress) {
            return response()->json([
                'success' => false,
                'message' => 'Shipping address not found',
            ], 400);
        }

        try {
            // Prepare shipment data
            $shipmentData = [
                'shipments' => [[
                    'waybill' => '',
                    'order' => $order->order_number,
                    'order_date' => $order->created_at->format('Y-m-d'),
                    'payment_mode' => $order->payment_method === 'cod' ? 'COD' : 'Prepaid',
                    'total_amount' => $order->total_amount,
                    'cod_amount' => $order->payment_method === 'cod' ? $order->total_amount : 0,
                    'add' => $shippingAddress['address_line_1'] . ($shippingAddress['address_line_2'] ?? ''),
                    'city' => $shippingAddress['city'],
                    'state' => $shippingAddress['state'],
                    'pin' => $shippingAddress['pincode'],
                    'phone' => $shippingAddress['phone'] ?? $order->user->phone,
                    'name' => $shippingAddress['full_name'],
                    'quantity' => $order->items->sum('quantity'),
                ]],
            ];

            // Create shipment via Delhivery API
            $response = Http::withHeaders([
                'Authorization' => 'Token ' . $this->clientSecret,
                'Content-Type' => 'application/json',
            ])->post("{$this->endpoint}/api/cmu/create.json", $shipmentData);

            if ($response->successful()) {
                $responseData = $response->json();
                
                // Update order with Delhivery data
                if (isset($responseData['packages'][0])) {
                    $package = $responseData['packages'][0];
                    $order->delhivery_waybill = $package['waybill'] ?? null;
                    $order->delhivery_data = $responseData;
                    $order->status = 'shipped';
                    $order->save();
                }

                return response()->json([
                    'success' => true,
                    'message' => 'Shipment created successfully',
                    'data' => $responseData,
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Failed to create shipment: ' . $response->body(),
            ], 400);

        } catch (\Exception $e) {
            Log::error('Delhivery shipment creation failed: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Shipment creation failed: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Track shipment
     */
    public function track(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        if (!$order->delhivery_waybill) {
            return response()->json([
                'success' => false,
                'message' => 'Waybill number not found',
            ], 400);
        }

        if (!$this->endpoint || !$this->clientSecret) {
            return response()->json([
                'success' => false,
                'message' => 'Delhivery is not configured',
            ], 500);
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Token ' . $this->clientSecret,
                'Content-Type' => 'application/json',
            ])->get("{$this->endpoint}/api/p/packing_slip", [
                'wbns' => $order->delhivery_waybill,
            ]);

            if ($response->successful()) {
                $trackingData = $response->json();
                
                // Update order tracking data
                $order->delhivery_tracking_data = $trackingData;
                $order->save();

                return response()->json([
                    'success' => true,
                    'data' => $trackingData,
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch tracking: ' . $response->body(),
            ], 400);

        } catch (\Exception $e) {
            Log::error('Delhivery tracking failed: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Tracking failed: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Cancel shipment
     */
    public function cancel(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        if (!$order->delhivery_waybill) {
            return response()->json([
                'success' => false,
                'message' => 'Waybill number not found',
            ], 400);
        }

        if (!$this->endpoint || !$this->clientSecret) {
            return response()->json([
                'success' => false,
                'message' => 'Delhivery is not configured',
            ], 500);
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Token ' . $this->clientSecret,
                'Content-Type' => 'application/json',
            ])->post("{$this->endpoint}/api/p/edit", [
                'waybill' => $order->delhivery_waybill,
                'cancel' => true,
            ]);

            if ($response->successful()) {
                $order->delhivery_cancelled = true;
                $order->status = 'cancelled';
                $order->save();

                return response()->json([
                    'success' => true,
                    'message' => 'Shipment cancelled successfully',
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Failed to cancel shipment: ' . $response->body(),
            ], 400);

        } catch (\Exception $e) {
            Log::error('Delhivery cancellation failed: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Cancellation failed: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Check pincode serviceability
     */
    public function checkPincode(Request $request)
    {
        $request->validate([
            'pincode' => 'required|string|size:6',
        ]);

        if (!$this->endpoint || !$this->clientSecret) {
            return response()->json([
                'success' => false,
                'message' => 'Delhivery is not configured',
            ], 500);
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Token ' . $this->clientSecret,
                'Content-Type' => 'application/json',
            ])->get("{$this->endpoint}/c/api/pin-codes/json/", [
                'filter_codes' => $request->pincode,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $serviceable = isset($data['delivery_codes']) && count($data['delivery_codes']) > 0;

                return response()->json([
                    'success' => true,
                    'data' => [
                        'pincode' => $request->pincode,
                        'serviceable' => $serviceable,
                        'details' => $data,
                    ],
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Failed to check pincode',
            ], 400);

        } catch (\Exception $e) {
            Log::error('Delhivery pincode check failed: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Pincode check failed: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get delivery estimate
     */
    public function deliveryEstimate(Request $request)
    {
        $request->validate([
            'pincode' => 'required|string|size:6',
        ]);

        if (!$this->endpoint || !$this->clientSecret) {
            return response()->json([
                'success' => false,
                'message' => 'Delhivery is not configured',
            ], 500);
        }

        try {
            // This is a placeholder - actual implementation depends on Delhivery API
            return response()->json([
                'success' => true,
                'data' => [
                    'pincode' => $request->pincode,
                    'estimated_days' => 3,
                    'message' => 'Estimated delivery: 3-5 business days',
                ],
            ]);
        } catch (\Exception $e) {
            Log::error('Delhivery estimate failed: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Estimate failed: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Create pickup request
     */
    public function createPickupRequest(Request $request)
    {
        // TODO: Implement pickup request creation
        return response()->json([
            'success' => true,
            'message' => 'Pickup request functionality will be implemented',
        ]);
    }

    /**
     * Print shipping label
     */
    public function printLabel(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        if (!$order->delhivery_waybill) {
            return response()->json([
                'success' => false,
                'message' => 'Waybill number not found',
            ], 400);
        }

        // TODO: Generate and return PDF label
        return response()->json([
            'success' => true,
            'message' => 'Label printing will be implemented',
            'data' => [
                'waybill' => $order->delhivery_waybill,
            ],
        ]);
    }
}




