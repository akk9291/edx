<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('hero_banners', function (Blueprint $table) {
            $table->string('subtitle')->nullable()->after('name');
            $table->string('button_text')->nullable()->after('deeplink');
        });
    }

    public function down(): void
    {
        Schema::table('hero_banners', function (Blueprint $table) {
            $table->dropColumn(['subtitle', 'button_text']);
        });
    }
};
