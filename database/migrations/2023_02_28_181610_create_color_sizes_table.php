<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('color_sizes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('color_id')->constrained('attribute_values', 'id');
            $table->foreignId('size_id')->constrained('attribute_values', 'id');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('color_sizes');
    }
};