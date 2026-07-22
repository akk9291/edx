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
            if (!Schema::hasColumn('categories', 'hero_image')) {
                $table->string('hero_image')->nullable()->after('image');
            }
            if (!Schema::hasColumn('categories', 'hero_text')) {
                $table->string('hero_text')->nullable()->after('hero_image');
            }
            if (!Schema::hasColumn('categories', 'hero_button_text')) {
                $table->string('hero_button_text')->nullable()->default('Shop Now')->after('hero_text');
            }
            if (!Schema::hasColumn('categories', 'banner_images')) {
                $table->json('banner_images')->nullable()->after('hero_button_text');
            }
            if (!Schema::hasColumn('categories', 'banner_texts')) {
                $table->json('banner_texts')->nullable()->after('banner_images');
            }
            if (!Schema::hasColumn('categories', 'bottom_banner_image')) {
                $table->string('bottom_banner_image')->nullable()->after('banner_texts');
            }
            if (!Schema::hasColumn('categories', 'bottom_banner_text')) {
                $table->string('bottom_banner_text')->nullable()->after('bottom_banner_image');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            if (Schema::hasColumn('categories', 'hero_image')) {
                $table->dropColumn('hero_image');
            }
            if (Schema::hasColumn('categories', 'hero_text')) {
                $table->dropColumn('hero_text');
            }
            if (Schema::hasColumn('categories', 'hero_button_text')) {
                $table->dropColumn('hero_button_text');
            }
            if (Schema::hasColumn('categories', 'banner_images')) {
                $table->dropColumn('banner_images');
            }
            if (Schema::hasColumn('categories', 'banner_texts')) {
                $table->dropColumn('banner_texts');
            }
            if (Schema::hasColumn('categories', 'bottom_banner_image')) {
                $table->dropColumn('bottom_banner_image');
            }
            if (Schema::hasColumn('categories', 'bottom_banner_text')) {
                $table->dropColumn('bottom_banner_text');
            }
        });
    }
};
