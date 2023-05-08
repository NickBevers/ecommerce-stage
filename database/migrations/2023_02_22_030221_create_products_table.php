<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->String('title')->unique();
            $table->String('slug')->nullable();
            $table->String('description')->nullable();
            $table->String('audience');
            $table->String('product_type')->default('simple');
            $table->foreignId('sub_category_id')->constrained();
            $table->String('extra_info')->nullable();
            $table->foreignId('user_id')->nullable()->default(1)->constrained()->onDelete('set null');
            $table->foreignId('brand_id')->nullable()->default(1)->constrained()->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};