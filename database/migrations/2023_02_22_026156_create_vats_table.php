<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('vats', function (Blueprint $table) {
            $table->id();
            $table->string('vat');
            $table->string('vat_percentage');
            $table->string('country_code')->default('BE');
            $table->boolean('default')->default(false);
            $table->unique(['vat', 'country_code']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vats');
    }
};
