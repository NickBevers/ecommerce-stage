<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('product_variation', function (Blueprint $table) {
            $table->id();
            $table->foreignId('variation_id')->constrained();
            $table->foreignId('product_id')->constrained();
            $table->integer('price');
            $table->integer('amount')->default(1);
            $table->String('sku');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_variation');
    }
};