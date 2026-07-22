<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::where('role', 'user')->get();
        $products = Product::where('is_active', true)->get();

        if ($users->isEmpty()) {
            $this->command->warn('No users found. Please run UserSeeder first.');
            return;
        }

        if ($products->isEmpty()) {
            $this->command->warn('No products found. Please run ProductSeeder first.');
            return;
        }

        $statuses = ['pending', 'processing', 'shipped', 'delivered', 'cancelled'];
        $paymentStatuses = ['pending', 'paid', 'paid', 'paid', 'failed']; // More paid than pending
        $paymentMethods = ['credit_card', 'debit_card', 'paypal', 'bank_transfer', 'cash_on_delivery'];

        // Create 30 orders
        for ($i = 0; $i < 30; $i++) {
            $user = $users->random();
            $status = $statuses[array_rand($statuses)];
            $paymentStatus = $paymentStatuses[array_rand($paymentStatuses)];
            $paymentMethod = $paymentMethods[array_rand($paymentMethods)];

            // Random date within last 3 months
            $createdAt = now()->subDays(rand(0, 90))->subHours(rand(0, 23))->subMinutes(rand(0, 59));

            // Select 1-4 random products
            $selectedProducts = $products->random(rand(1, 4));
            
            $subtotal = 0;
            $orderItems = [];

            foreach ($selectedProducts as $product) {
                $quantity = rand(1, 3);
                $price = $product->sale_price ?? $product->price;
                $total = $price * $quantity;
                $subtotal += $total;

                $orderItems[] = [
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'product_sku' => $product->sku,
                    'quantity' => $quantity,
                    'price' => $price,
                    'total' => $total,
                ];
            }

            $tax = round($subtotal * 0.10, 2); // 10% tax
            $shipping = $subtotal > 50 ? 0 : round(rand(500, 1500) / 100, 2); // Free shipping over $50
            $total = $subtotal + $tax + $shipping;

            // Generate unique order number
            $orderNumber = 'ORD-' . strtoupper(Str::random(10));

            $order = Order::create([
                'order_number' => $orderNumber,
                'user_id' => $user->id,
                'customer_name' => $user->name,
                'customer_email' => $user->email,
                'customer_phone' => '+1' . rand(2000000000, 9999999999),
                'billing_address' => $this->generateAddress(),
                'shipping_address' => $this->generateAddress(),
                'subtotal' => $subtotal,
                'tax' => $tax,
                'shipping' => $shipping,
                'total' => $total,
                'status' => $status,
                'payment_status' => $paymentStatus,
                'payment_method' => $paymentMethod,
                'notes' => rand(0, 1) ? $this->generateNotes() : null,
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ]);

            // Create order items
            foreach ($orderItems as $item) {
                OrderItem::create(array_merge($item, [
                    'order_id' => $order->id,
                    'created_at' => $createdAt,
                    'updated_at' => $createdAt,
                ]));
            }
        }

        $this->command->info('Orders seeded successfully!');
    }

    private function generateAddress(): string
    {
        $streets = ['Main St', 'Oak Ave', 'Park Blvd', 'Elm St', 'Maple Dr', 'Cedar Ln', 'Pine Rd'];
        $cities = ['New York', 'Los Angeles', 'Chicago', 'Houston', 'Phoenix', 'Philadelphia', 'San Antonio'];
        $states = ['NY', 'CA', 'IL', 'TX', 'AZ', 'PA', 'TX'];

        $streetNumber = rand(100, 9999);
        $street = $streets[array_rand($streets)];
        $city = $cities[array_rand($cities)];
        $state = $states[array_rand($states)];
        $zip = rand(10000, 99999);

        return "{$streetNumber} {$street}\n{$city}, {$state} {$zip}\nUnited States";
    }

    private function generateNotes(): string
    {
        $notes = [
            'Please leave at front door',
            'Ring doorbell on delivery',
            'Gift wrapping requested',
            'Handle with care',
            'Delivery before 5 PM please',
            'Leave with neighbor if not home',
        ];

        return $notes[array_rand($notes)];
    }
}
