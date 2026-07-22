# Shiprocket Delivery Integration

## 1. Add credentials to `.env`

Add these lines (use your Shiprocket login email and password):

```env
SHIPROCKET_EMAIL=perchbypexpo@gmail.com
SHIPROCKET_PASSWORD=your_password_here
SHIPROCKET_PICKUP_POSTCODE=110001
```

- **SHIPROCKET_EMAIL** – Your Shiprocket account email  
- **SHIPROCKET_PASSWORD** – Your Shiprocket account password  
- **SHIPROCKET_PICKUP_POSTCODE** – Your warehouse/seller pickup pincode (default `110001`). Change to your actual pickup location pincode.

Optional:

```env
SHIPROCKET_API_URL=https://apiv2.shiprocket.in
```

## 2. What is implemented

- **Shipping rate at checkout**  
  `POST /api/shipping/calculate` with `pincode`, optional `weight`, `cod_amount` now uses Shiprocket first to return serviceability and shipping charge. If Shiprocket is not configured, it falls back to Delhivery or a flat rate.

- **Create shipment (admin)**  
  After an order is placed, create a Shiprocket order/shipment from admin:
  - **API:** `POST /api/admin/orders/{orderId}/shiprocket/create-shipment`  
  - The order’s shipping address and items are sent to Shiprocket; `shiprocket_order_id`, `shiprocket_shipment_id`, and AWB are stored on the order.

- **Track shipment (admin)**  
  - **API:** `GET /api/admin/orders/{orderId}/shiprocket/track`

## 3. Using dynamic shipping on checkout

The checkout page can call the shipping API when the user enters a pincode and use the returned `shipping_charge` and `estimated_delivery` to show and send the correct shipping cost with the order. The backend already supports this; the frontend only needs to call `POST /api/shipping/calculate` and pass the returned `shipping_charge` as `shipping_charge` when placing the order.

## 4. Security

Do not commit `.env` or put real passwords in code. Keep `SHIPROCKET_PASSWORD` only in `.env` on the server.
