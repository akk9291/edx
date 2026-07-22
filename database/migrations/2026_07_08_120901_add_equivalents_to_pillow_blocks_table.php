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
            $table->string('equiv_skf')->nullable()->after('pdf_catalogue');
            $table->string('equiv_fag')->nullable()->after('equiv_skf');
            $table->string('equiv_ntn')->nullable()->after('equiv_fag');
            $table->string('equiv_timken')->nullable()->after('equiv_ntn');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pillow_blocks', function (Blueprint $table) {
            $table->dropColumn(['equiv_skf', 'equiv_fag', 'equiv_ntn', 'equiv_timken']);
        });
    }
};
