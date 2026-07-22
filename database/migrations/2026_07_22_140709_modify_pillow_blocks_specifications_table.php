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
            $table->json('specifications')->nullable()->after('bearing_number');
            $table->dropColumn([
                'shaft_size_display',
                'center_height',
                'overall_length',
                'hole_distance',
                'base_width',
                'bolt_hole_length',
                'bolt_hole_width',
                'base_thickness',
                'overall_height',
                'inner_ring_width',
                'set_screw_distance',
                'bearing_insert_number',
                'housing_number',
                'weight',
                'j7'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pillow_blocks', function (Blueprint $table) {
            $table->dropColumn('specifications');
            
            $table->string('shaft_size_display')->nullable()->after('bearing_number');
            $table->decimal('center_height', 10, 2)->nullable()->after('shaft_size_display');
            $table->decimal('overall_length', 10, 2)->nullable()->after('center_height');
            $table->decimal('hole_distance', 10, 2)->nullable()->after('overall_length');
            $table->decimal('base_width', 10, 2)->nullable()->after('hole_distance');
            $table->decimal('bolt_hole_length', 10, 2)->nullable()->after('base_width');
            $table->decimal('bolt_hole_width', 10, 2)->nullable()->after('bolt_hole_length');
            $table->decimal('base_thickness', 10, 2)->nullable()->after('bolt_hole_width');
            $table->decimal('overall_height', 10, 2)->nullable()->after('base_thickness');
            $table->decimal('inner_ring_width', 10, 2)->nullable()->after('overall_height');
            $table->decimal('set_screw_distance', 10, 2)->nullable()->after('inner_ring_width');
            $table->string('bearing_insert_number')->nullable()->after('set_screw_distance');
            $table->string('housing_number')->nullable()->after('bearing_insert_number');
            $table->decimal('weight', 10, 2)->nullable()->after('housing_number');
            $table->integer('j7')->nullable()->after('weight');
        });
    }
};
