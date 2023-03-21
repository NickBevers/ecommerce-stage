<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sku_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->string('title');
            $table->text('body');
            $table->integer('score');
            $table->boolean('approved')->default(true);
            $table->integer('useful_count')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};