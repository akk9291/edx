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
        Schema::create('pillow_blocks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('sku')->unique()->nullable();
            $table->foreignId('category_id')->nullable()->constrained('categories')->onDelete('set null');
            $table->string('brand')->nullable();
            $table->text('short_description')->nullable();
            $table->longText('description')->nullable();
            $table->decimal('price', 10, 2)->default(0); // MRP
            $table->decimal('sale_price', 10, 2)->nullable();
            $table->string('image')->nullable(); // Featured Image
            $table->string('video')->nullable(); // Product Video
            $table->string('pdf_catalogue')->nullable(); // PDF Catalogue
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_keywords', 1024)->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('in_stock')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_new_arrival')->default(false);
            $table->integer('sort_order')->default(0);

            // Specifications (stored as separate columns)
            $table->string('bearing_number')->nullable();
            $table->string('shaft_size_display')->nullable();
            $table->decimal('shaft_diameter', 10, 2)->nullable();
            $table->decimal('center_height', 10, 2)->nullable();
            $table->decimal('overall_length', 10, 2)->nullable();
            $table->decimal('hole_distance', 10, 2)->nullable();
            $table->decimal('base_width', 10, 2)->nullable();
            $table->decimal('bolt_hole_length', 10, 2)->nullable();
            $table->decimal('bolt_hole_width', 10, 2)->nullable();
            $table->decimal('base_thickness', 10, 2)->nullable();
            $table->decimal('overall_height', 10, 2)->nullable();
            $table->decimal('inner_ring_width', 10, 2)->nullable();
            $table->decimal('set_screw_distance', 10, 2)->nullable();
            $table->string('bearing_insert_number')->nullable();
            $table->string('housing_number')->nullable();
            $table->decimal('weight', 10, 2)->nullable();
            $table->integer('j7')->nullable();
            $table->integer('h7')->nullable();
            $table->integer('h8')->nullable();
            $table->integer('h9')->nullable();

            $table->timestamps();
        });

        Schema::create('pillow_block_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pillow_block_id')->constrained('pillow_blocks')->onDelete('cascade');
            $table->string('image_path');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pillow_block_images');
        Schema::dropIfExists('pillow_blocks');
    }
};
