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
            if (!Schema::hasColumn('categories', 'testimonial_text')) {
                $table->text('testimonial_text')->nullable()->after('bottom_banner_text');
            }
            if (!Schema::hasColumn('categories', 'additional_banner_image')) {
                $table->string('additional_banner_image')->nullable()->after('testimonial_text');
            }
            if (!Schema::hasColumn('categories', 'additional_banner_text')) {
                $table->string('additional_banner_text')->nullable()->after('additional_banner_image');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            if (Schema::hasColumn('categories', 'testimonial_text')) {
                $table->dropColumn('testimonial_text');
            }
            if (Schema::hasColumn('categories', 'additional_banner_image')) {
                $table->dropColumn('additional_banner_image');
            }
            if (Schema::hasColumn('categories', 'additional_banner_text')) {
                $table->dropColumn('additional_banner_text');
            }
        });
    }
};
