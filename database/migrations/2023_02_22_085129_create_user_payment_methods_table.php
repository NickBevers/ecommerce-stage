<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('user_payment_methods', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('payment_type_id')->constrained('payment_types');
            $table->String('extra_info');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_payment_methods');
    }
};