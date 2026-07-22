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
        Schema::table('main_categories', function (Blueprint $table) {
            if (!Schema::hasColumn('main_categories', 'hero_image')) {
                $table->string('hero_image')->nullable()->after('image');
            }
            if (!Schema::hasColumn('main_categories', 'hero_text')) {
                $table->string('hero_text')->nullable()->after('hero_image');
            }
            if (!Schema::hasColumn('main_categories', 'hero_button_text')) {
                $table->string('hero_button_text')->nullable()->after('hero_text');
            }
            if (!Schema::hasColumn('main_categories', 'banner_images')) {
                $table->json('banner_images')->nullable()->after('hero_button_text');
            }
            if (!Schema::hasColumn('main_categories', 'banner_texts')) {
                $table->json('banner_texts')->nullable()->after('banner_images');
            }
            if (!Schema::hasColumn('main_categories', 'bottom_banner_image')) {
                $table->string('bottom_banner_image')->nullable()->after('banner_texts');
            }
            if (!Schema::hasColumn('main_categories', 'bottom_banner_text')) {
                $table->string('bottom_banner_text')->nullable()->after('bottom_banner_image');
            }
            if (!Schema::hasColumn('main_categories', 'testimonial_text')) {
                $table->text('testimonial_text')->nullable()->after('bottom_banner_text');
            }
            if (!Schema::hasColumn('main_categories', 'additional_banner_image')) {
                $table->string('additional_banner_image')->nullable()->after('testimonial_text');
            }
            if (!Schema::hasColumn('main_categories', 'additional_banner_text')) {
                $table->string('additional_banner_text')->nullable()->after('additional_banner_image');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('main_categories', function (Blueprint $table) {
            if (Schema::hasColumn('main_categories', 'hero_image')) {
                $table->dropColumn('hero_image');
            }
            if (Schema::hasColumn('main_categories', 'hero_text')) {
                $table->dropColumn('hero_text');
            }
            if (Schema::hasColumn('main_categories', 'hero_button_text')) {
                $table->dropColumn('hero_button_text');
            }
            if (Schema::hasColumn('main_categories', 'banner_images')) {
                $table->dropColumn('banner_images');
            }
            if (Schema::hasColumn('main_categories', 'banner_texts')) {
                $table->dropColumn('banner_texts');
            }
            if (Schema::hasColumn('main_categories', 'bottom_banner_image')) {
                $table->dropColumn('bottom_banner_image');
            }
            if (Schema::hasColumn('main_categories', 'bottom_banner_text')) {
                $table->dropColumn('bottom_banner_text');
            }
            if (Schema::hasColumn('main_categories', 'testimonial_text')) {
                $table->dropColumn('testimonial_text');
            }
            if (Schema::hasColumn('main_categories', 'additional_banner_image')) {
                $table->dropColumn('additional_banner_image');
            }
            if (Schema::hasColumn('main_categories', 'additional_banner_text')) {
                $table->dropColumn('additional_banner_text');
            }
        });
    }
};
