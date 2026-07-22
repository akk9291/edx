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
        // Check if order_items table exists, if not create it
        if (!Schema::hasTable('order_items')) {
            Schema::create('order_items', function (Blueprint $table) {
                $table->id();
                $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
                $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
                $table->integer('quantity')->default(1);
                $table->decimal('price', 10, 2);
                $table->string('size')->nullable();
                $table->string('color')->nullable();
                $table->timestamps();
            });
        } else {
            // If table exists, add missing columns
            Schema::table('order_items', function (Blueprint $table) {
                if (!Schema::hasColumn('order_items', 'size')) {
                    $table->string('size')->nullable()->after('price');
                }
                if (!Schema::hasColumn('order_items', 'color')) {
                    $table->string('color')->nullable()->after('size');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            if (Schema::hasColumn('order_items', 'size')) {
                $table->dropColumn('size');
            }
            if (Schema::hasColumn('order_items', 'color')) {
                $table->dropColumn('color');
            }
        });
    }
};




