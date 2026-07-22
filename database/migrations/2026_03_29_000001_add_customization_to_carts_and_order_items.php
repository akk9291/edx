<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('carts', function (Blueprint $table) {
            $table->text('customization_json')->nullable()->after('color');
            $table->string('customization_image')->nullable()->after('customization_json');
            $table->decimal('custom_unit_price', 10, 2)->nullable()->after('customization_image');
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->text('customization_json')->nullable()->after('color');
            $table->string('customization_image')->nullable()->after('customization_json');
        });
    }

    public function down(): void
    {
        Schema::table('carts', function (Blueprint $table) {
            $table->dropColumn(['customization_json', 'customization_image', 'custom_unit_price']);
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->dropColumn(['customization_json', 'customization_image']);
        });
    }
};
