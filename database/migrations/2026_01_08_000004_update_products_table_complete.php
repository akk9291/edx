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
        Schema::table('products', function (Blueprint $table) {
            if (!Schema::hasColumn('products', 'short_description')) {
                $table->text('short_description')->nullable()->after('description');
            }
            if (!Schema::hasColumn('products', 'sale_price')) {
                $table->decimal('sale_price', 10, 2)->nullable()->after('price');
            }
            if (!Schema::hasColumn('products', 'images')) {
                $table->json('images')->nullable()->after('image');
            }
            if (!Schema::hasColumn('products', 'sizes')) {
                $table->json('sizes')->nullable()->after('images');
            }
            if (!Schema::hasColumn('products', 'colors')) {
                $table->json('colors')->nullable()->after('sizes');
            }
            if (!Schema::hasColumn('products', 'stock')) {
                $table->integer('stock')->default(0)->after('stock_quantity');
            }
            if (!Schema::hasColumn('products', 'is_new_arrival')) {
                $table->boolean('is_new_arrival')->default(false)->after('is_featured');
            }
            if (!Schema::hasColumn('products', 'product_type')) {
                $table->string('product_type')->nullable()->after('is_active');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $columns = ['short_description', 'sale_price', 'images', 'sizes', 'colors', 'stock', 'is_new_arrival', 'product_type'];
            foreach ($columns as $column) {
                if (Schema::hasColumn('products', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};




