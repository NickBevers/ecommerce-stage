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
            $table->String('description')->nullable();
            $table->String('audience');
            $table->String('product_type')->default('simple');
            $table->foreignId('sub_category_id')->constrained();
            $table->String('extra_info')->nullable();
            $table->boolean('is_active')->default(true);
            $table->foreignId('user_id')->default(1)->constrained()->onDelete('cascade');
            $table->foreignId('brand_id')->default(1)->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};