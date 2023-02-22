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
            $table->integer('price');
            $table->integer('stock');
            $table->foreignId('category_id')->nullable()->references('id')->on('categories');
            $table->json('promos')->nullable();
            $table->timestamp('created_at');
            $table->timestamp('modified_at');
            $table->timestamp('deleted_at');
            $table->String('extra_info');
            $table->json('images');
            $table->String('sku');
            $table->integer('product_number');
            $table->boolean('is_promotion')->default(false);
            $table->boolean('is_active')->default(true);
            $table->foreignId('seller_id')->nullable()->references('id')->on('users');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};