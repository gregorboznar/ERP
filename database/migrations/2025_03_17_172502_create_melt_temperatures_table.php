<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
  {
    if (!Schema::hasTable('melt_temperatures')) {
      Schema::create('melt_temperatures', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('user_id');
        $table->unsignedBigInteger('machine_id');
        $table->unsignedBigInteger('product_id');
        $table->unsignedBigInteger('series_id');
        $table->datetime('recorded_at')->nullable();
        $table->timestamps();

        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        $table->foreign('machine_id')->references('id')->on('machines')->onDelete('cascade');
        $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        $table->foreign('series_id')->references('id')->on('series_tenders')->onDelete('cascade');
      });
    }
  }

  public function down(): void
  {
    Schema::dropIfExists('melt_temperatures');
  }
};
