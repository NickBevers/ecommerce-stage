<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('sku_variations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sku_id');
            $table->unsignedBigInteger('variation_id');
            $table->string('variation_type');
            $table->timestamps();

            $table->foreign('sku_id')
                ->references('id')
                ->on('skus')
                ->onDelete('cascade');

//            $table->foreign('variation_id')
//                ->references('id')
//                ->on('attribute_values')
//                ->onDelete('cascade');

            $table->unique(['sku_id', 'variation_id', 'variation_type']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('sku_variations');
    }
};