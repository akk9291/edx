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
        Schema::table('categories', function (Blueprint $table) {
            if (!Schema::hasColumn('categories', 'main_category_id')) {
                $table->foreignId('main_category_id')->nullable()->after('image')->constrained('main_categories')->onDelete('cascade');
            }
            if (!Schema::hasColumn('categories', 'parent_id')) {
                // Keep parent_id for existing hierarchy if needed
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            if (Schema::hasColumn('categories', 'main_category_id')) {
                $table->dropForeign(['main_category_id']);
                $table->dropColumn('main_category_id');
            }
        });
    }
};




