<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // order_number already exists in original migration, so skip it
            if (!Schema::hasColumn('orders', 'status_locked')) {
                $table->boolean('status_locked')->default(false)->after('status');
            }
            if (!Schema::hasColumn('orders', 'total_amount')) {
                // Check if 'total' exists, if yes, rename it or keep both
                if (Schema::hasColumn('orders', 'total')) {
                    // Keep both for compatibility
                    $table->decimal('total_amount', 10, 2)->nullable()->after('total');
                } else {
                    $table->decimal('total_amount', 10, 2)->after('status_locked');
                }
            }
            if (!Schema::hasColumn('orders', 'shipping_charge')) {
                // Check if 'shipping' exists
                if (Schema::hasColumn('orders', 'shipping')) {
                    $table->decimal('shipping_charge', 10, 2)->nullable()->after('shipping');
                } else {
                    $table->decimal('shipping_charge', 10, 2)->default(0)->after('total_amount');
                }
            }
            // Wait for coupons table to be created first, so this will be in a later migration
            // if (!Schema::hasColumn('orders', 'coupon_id')) {
            //     $table->foreignId('coupon_id')->nullable()->after('shipping_charge');
            // }
            if (!Schema::hasColumn('orders', 'coupon_discount')) {
                $table->decimal('coupon_discount', 10, 2)->default(0)->after('shipping_charge');
            }
            if (!Schema::hasColumn('orders', 'coupon_id')) {
                // Add coupon_id without foreign key first (will be added later)
                $table->unsignedBigInteger('coupon_id')->nullable()->after('shipping_charge');
            }
            // Convert existing text fields to JSON if needed
            if (Schema::hasColumn('orders', 'shipping_address') && Schema::getColumnType('orders', 'shipping_address') !== 'json') {
                // Keep as is for now, will need separate migration to convert
            } else if (!Schema::hasColumn('orders', 'shipping_address')) {
                $table->json('shipping_address')->nullable()->after('coupon_discount');
            }
            if (Schema::hasColumn('orders', 'billing_address') && Schema::getColumnType('orders', 'billing_address') !== 'json') {
                // Keep as is
            } else if (!Schema::hasColumn('orders', 'billing_address')) {
                $table->json('billing_address')->nullable()->after('shipping_address');
            }
            // payment_method and payment_status already exist
            if (!Schema::hasColumn('orders', 'razorpay_order_id')) {
                $table->string('razorpay_order_id')->nullable()->after('payment_status');
            }
            if (!Schema::hasColumn('orders', 'razorpay_payment_id')) {
                $table->string('razorpay_payment_id')->nullable()->after('razorpay_order_id');
            }
            if (!Schema::hasColumn('orders', 'razorpay_signature')) {
                $table->string('razorpay_signature')->nullable()->after('razorpay_payment_id');
            }
            if (!Schema::hasColumn('orders', 'delhivery_waybill')) {
                $table->string('delhivery_waybill')->nullable()->after('razorpay_signature');
            }
            if (!Schema::hasColumn('orders', 'delhivery_data')) {
                $table->json('delhivery_data')->nullable()->after('delhivery_waybill');
            }
            if (!Schema::hasColumn('orders', 'delhivery_tracking_data')) {
                $table->json('delhivery_tracking_data')->nullable()->after('delhivery_data');
            }
            if (!Schema::hasColumn('orders', 'delhivery_cancelled')) {
                $table->boolean('delhivery_cancelled')->default(false)->after('delhivery_tracking_data');
            }
            // notes already exists
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $columns = [
                'order_number', 'status', 'status_locked', 'total_amount', 'shipping_charge',
                'coupon_discount', 'shipping_address', 'billing_address', 'payment_method',
                'payment_status', 'razorpay_order_id', 'razorpay_payment_id', 'razorpay_signature',
                'delhivery_waybill', 'delhivery_data', 'delhivery_tracking_data',
                'delhivery_cancelled', 'notes'
            ];
            
            if (Schema::hasColumn('orders', 'coupon_id')) {
                $table->dropForeign(['coupon_id']);
                $table->dropColumn('coupon_id');
            }
            
            foreach ($columns as $column) {
                if (Schema::hasColumn('orders', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};

