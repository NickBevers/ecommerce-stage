<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('skus', function (Blueprint $table) {
            $table->id();
            $table->string('sku')->unique();
            $table->foreignId('product_id')->constrained();
            $table->integer('amount');
            $table->foreignId('vat_id')->default(27)->constrained();
            $table->float('price_excl_vat');
            $table->float('price_incl_vat');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('skus');
    }
};