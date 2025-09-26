<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('product_measurement_characteristics', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('measurement_characteristic_id');
            $table->timestamps();

            $table->foreign('product_id', 'fk_pmc_product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('measurement_characteristic_id', 'fk_pmc_measurement_id')->references('id')->on('measurement_characteristics')->onDelete('cascade');
            
            $table->unique(['product_id', 'measurement_characteristic_id'], 'product_measurement_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_measurement_characteristics');
    }
};
