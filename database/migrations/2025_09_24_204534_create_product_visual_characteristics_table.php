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
        Schema::create('product_visual_characteristics', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('visual_characteristic_id');
            $table->timestamps();

            $table->foreign('product_id', 'fk_pvc_product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('visual_characteristic_id', 'fk_pvc_visual_id')->references('id')->on('visual_characteristics')->onDelete('cascade');
            
            $table->unique(['product_id', 'visual_characteristic_id'], 'product_visual_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_visual_characteristics');
    }
};
