<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('inventories', function (Blueprint $table) {
            if (!Schema::hasColumn('inventories', 'price')) {
                $table->decimal('price', 12, 2)->nullable()->after('sold_quantity');
            }
            if (!Schema::hasColumn('inventories', 'sale_price')) {
                $table->decimal('sale_price', 12, 2)->nullable()->after('price');
            }
            if (!Schema::hasColumn('inventories', 'image')) {
                $table->string('image')->nullable()->after('sale_price');
            }
        });
    }

    public function down(): void
    {
        Schema::table('inventories', function (Blueprint $table) {
            $cols = ['price', 'sale_price', 'image'];
            foreach ($cols as $col) {
                if (Schema::hasColumn('inventories', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
