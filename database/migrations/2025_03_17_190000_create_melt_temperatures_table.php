<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMeltTemperaturesTable extends Migration
{
  public function up()
  {
    Schema::table('melt_temperatures', function (Blueprint $table) {
      // Drop the temperature_readings column if it exists
      if (Schema::hasColumn('melt_temperatures', 'temperature_readings')) {
        $table->dropColumn('temperature_readings');
      }

      // Make sure foreign keys are not nullable
      $table->foreignId('user_id')->nullable(false)->change();
      $table->foreignId('machine_id')->nullable(false)->change();
      $table->foreignId('product_id')->nullable(false)->change();
      $table->foreignId('series_id')->nullable(false)->change();
    });
  }

  public function down()
  {
    Schema::table('melt_temperatures', function (Blueprint $table) {
      $table->json('temperature_readings')->nullable();

      // Make foreign keys nullable again
      $table->foreignId('user_id')->nullable()->change();
      $table->foreignId('machine_id')->nullable()->change();
      $table->foreignId('product_id')->nullable()->change();
      $table->foreignId('series_id')->nullable()->change();
    });
  }
}
