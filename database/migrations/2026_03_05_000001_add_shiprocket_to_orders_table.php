<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (! Schema::hasColumn('orders', 'shiprocket_order_id')) {
                $table->unsignedBigInteger('shiprocket_order_id')->nullable()->after('delhivery_cancelled');
            }
            if (! Schema::hasColumn('orders', 'shiprocket_shipment_id')) {
                $table->unsignedBigInteger('shiprocket_shipment_id')->nullable()->after('shiprocket_order_id');
            }
            if (! Schema::hasColumn('orders', 'shiprocket_awb')) {
                $table->string('shiprocket_awb')->nullable()->after('shiprocket_shipment_id');
            }
            if (! Schema::hasColumn('orders', 'shiprocket_data')) {
                $table->json('shiprocket_data')->nullable()->after('shiprocket_awb');
            }
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $cols = ['shiprocket_order_id', 'shiprocket_shipment_id', 'shiprocket_awb', 'shiprocket_data'];
            foreach ($cols as $col) {
                if (Schema::hasColumn('orders', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
