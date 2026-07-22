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
        // Add foreign key constraint after coupons table is created
        if (Schema::hasTable('coupons') && Schema::hasColumn('orders', 'coupon_id')) {
            $connection = Schema::getConnection();
            $databaseName = $connection->getDatabaseName();
            
            // Check if foreign key already exists using raw SQL
            $foreignKeys = $connection->select("
                SELECT CONSTRAINT_NAME 
                FROM information_schema.KEY_COLUMN_USAGE 
                WHERE TABLE_SCHEMA = ? 
                AND TABLE_NAME = 'orders'
                AND COLUMN_NAME = 'coupon_id'
                AND REFERENCED_TABLE_NAME = 'coupons'
                AND REFERENCED_COLUMN_NAME = 'id'
            ", [$databaseName]);
            
            // Only add foreign key if it doesn't exist
            if (empty($foreignKeys)) {
                Schema::table('orders', function (Blueprint $table) {
                    $table->foreign('coupon_id')->references('id')->on('coupons')->onDelete('set null');
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('orders', 'coupon_id')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->dropForeign(['coupon_id']);
            });
        }
    }
};

