<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('attribute_value_sku', function (Blueprint $table) {
            $table->foreignId('sku_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('attribute_value_id')->constrained();
            $table->unique(['sku_id', 'attribute_value_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attribute_value_sku');
    }
};