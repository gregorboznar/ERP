<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMeltTemperaturesTable extends Migration
{
  public function up()
  {
    Schema::create('melt_temperatures', function (Blueprint $table) {
      $table->id();
      $table->foreignId('user_id')->constrained()->nullable(); // Foreign key to users table
      $table->foreignId('machine_id')->constrained()->nullable(); // Foreign key to machines table
      $table->foreignId('product_id')->constrained()->nullable(); // Foreign key to products table
      $table->foreignId('series_id')->constrained('series_tenders')->nullable(); // Foreign key to series_tenders table
      $table->json('temperature_readings')->nullable(); // JSON column for temperature readings
      $table->softDeletes(); // Soft deletes
      $table->timestamps(); // Created at and updated at
    });
  }

  public function down()
  {
    Schema::dropIfExists('melt_temperatures');
  }
}
