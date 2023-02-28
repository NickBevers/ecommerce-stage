<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->String('title');
            $table->String('description');
            $table->String('audience');
            $table->foreignId('category_id')->references('id')->on('categories');
            $table->json('promos')->nullable();
            $table->String('extra_info');
            $table->String('sku');
            $table->boolean('is_promotion')->default(false);
            $table->boolean('is_active')->default(true);
            $table->foreignId('seller_id')->nullable()->references('id')->on('users');
            $table->foreignId('brand_id')->references('id')->on('brands');
            $table->foreignId('material_id')->references('id')->on('materials');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};