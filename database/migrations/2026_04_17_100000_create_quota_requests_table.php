<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quota_requests', function (Blueprint $table) {
            $table->id();
            $table->string('reference', 32)->unique();
            $table->string('company_name')->nullable();
            $table->string('contact_name');
            $table->string('email');
            $table->string('phone', 64)->nullable();
            $table->text('message')->nullable();
            $table->string('status', 32)->default('pending');
            $table->text('admin_notes')->nullable();
            $table->timestamps();
        });

        Schema::create('quota_request_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quota_request_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->nullable()->constrained()->nullOnDelete();
            $table->unsignedInteger('quantity');
            $table->string('product_sku', 128)->nullable();
            $table->string('product_name')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quota_request_items');
        Schema::dropIfExists('quota_requests');
    }
};
