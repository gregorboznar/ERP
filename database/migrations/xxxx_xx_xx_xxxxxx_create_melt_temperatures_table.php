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
      $table->foreignId('user_id')->constrained();
      $table->foreignId('machine_id')->constrained();
      $table->foreignId('product_id')->constrained();
      $table->foreignId('series_id')->constrained('series_tenders');
      $table->timestamps();
    });
  }

  public function down()
  {
    Schema::dropIfExists('melt_temperatures');
  }
}
