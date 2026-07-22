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
        Schema::table('pillow_blocks', function (Blueprint $table) {
            $table->dropColumn(['shaft_diameter', 'h7', 'h8', 'h9']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pillow_blocks', function (Blueprint $table) {
            $table->decimal('shaft_diameter', 8, 2)->nullable()->after('shaft_size_display');
            $table->integer('h7')->nullable()->after('j7');
            $table->integer('h8')->nullable()->after('h7');
            $table->integer('h9')->nullable()->after('h8');
        });
    }
};
