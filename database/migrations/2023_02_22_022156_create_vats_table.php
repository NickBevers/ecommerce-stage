<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('vats', function (Blueprint $table) {
            $table->id();
            $table->string('country');
            $table->string('country_code');
            $table->string('vat_type');
            $table->string('vat_rate');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vats');
    }
};
