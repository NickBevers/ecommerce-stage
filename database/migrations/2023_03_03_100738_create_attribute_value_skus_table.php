<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
//        Schema::create('attribute_value_sku', function (Blueprint $table) {
////            $table->foreignId('sku_id')->constrained();
//            $table->integer('sku_id')->unsigned();
//            $table->integer('attribute_value_skuable_id')->unsigned();
//            $table->string('attribute_value_skuable_type');
//            $table->primary(['sku_id', 'attribute_value_skuable_id', 'attribute_value_skuable_type']);
//        });


        Schema::create('attribute_value_sku', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sku_id');
            $table->unsignedBigInteger('attribute_value_id');

            $table->foreign('sku_id')->references('id')->on('skus')->onDelete('cascade');
            $table->foreign('attribute_value_id')->references('id')->on('attribute_values')->onDelete('cascade');

            $table->string('attribute_value_type'); // This column stores the class name of the related model
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attribute_value_sku');
    }
};