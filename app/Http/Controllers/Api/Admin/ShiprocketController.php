<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\ShiprocketService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ShiprocketController extends Controller
{
    /**
     * Create Shiprocket order/shipment for an order
     */
    public function createShipment(Request $request, $id)
    {
        $order = Order::with(['user', 'items.product'])->findOrFail($id);

        if ($order->shiprocket_order_id) {
            return response()->json([
                'success' => false,
                'message' => 'Shiprocket order already created for this order',
            ], 400);
        }

        $shippingAddress = $order->shipping_address;
        if (! $shippingAddress || empty($shippingAddress['pincode'])) {
            return response()->json([
                'success' => false,
                'message' => 'Shipping address or pincode missing',
            ], 400);
        }

        $service = app(ShiprocketService::class);
        if (! $service->isConfigured()) {
            return response()->json([
                'success' => false,
                'message' => 'Shiprocket is not configured. Set SHIPROCKET_EMAIL and SHIPROCKET_PASSWORD in .env',
            ], 500);
        }

        $orderData = [
            'order_number' => $order->order_number,
            'total_amount' => (float) $order->total_amount,
            'payment_method' => $order->payment_method ?? 'cod',
            'shipping_address' => $shippingAddress,
            'customer_phone' => $order->customer_phone ?? $shippingAddress['phone'] ?? '',
            'customer_email' => $order->customer_email ?? $shippingAddress['email'] ?? '',
        ];

        $items = [];
        $totalQty = 0;
        foreach ($order->items as $item) {
            $items[] = [
                'name' => $item->product_name ?? $item->product?->name ?? 'Product',
                'sku' => $item->product_sku ?? $item->product?->sku ?? '',
                'quantity' => $item->quantity,
                'price' => (float) $item->price,
            ];
            $totalQty += $item->quantity;
        }
        $weightKg = max(0.5, $totalQty * 0.5);

        $result = $service->createOrder($orderData, $items, $weightKg);

        if (! $result['success']) {
            Log::warning('Shiprocket create order failed', ['order_id' => $order->id, 'result' => $result]);
            return response()->json([
                'success' => false,
                'message' => $result['message'] ?? 'Failed to create Shiprocket order',
            ], 400);
        }

        $order->shiprocket_order_id = $result['order_id'] ?? null;
        $order->shiprocket_shipment_id = $result['shipment_id'] ?? null;
        $order->shiprocket_awb = $result['data']['awb_code'] ?? $result['data']['awb'] ?? null;
        $order->shiprocket_data = $result['data'] ?? [];
        $order->status = 'processing';
        $order->save();

        return response()->json([
            'success' => true,
            'message' => 'Shiprocket order created successfully',
            'data' => [
                'shiprocket_order_id' => $order->shiprocket_order_id,
                'shiprocket_shipment_id' => $order->shiprocket_shipment_id,
                'shiprocket_awb' => $order->shiprocket_awb,
            ],
        ]);
    }

    /**
     * Track Shiprocket shipment
     */
    public function track(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        if (! $order->shiprocket_order_id) {
            return response()->json([
                'success' => false,
                'message' => 'Shiprocket order not created for this order',
            ], 400);
        }

        $service = app(ShiprocketService::class);
        $result = $service->track((int) $order->shiprocket_order_id);

        if (! $result['success']) {
            return response()->json([
                'success' => false,
                'message' => $result['message'] ?? 'Tracking failed',
            ], 400);
        }

        return response()->json([
            'success' => true,
            'data' => $result['data'] ?? [],
        ]);
    }
}
