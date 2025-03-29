<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up()
  {
    Schema::create('scp_measurement_fields', function (Blueprint $table) {
      $table->id();
      $table->foreignId('scp_measurement_id');
      $table->integer('nest_number');
      $table->integer('field_number');
      $table->decimal('measurement_value', 10, 3);
      $table->timestamps();
    });
  }

  public function down()
  {
    Schema::dropIfExists('scp_measurement_fields');
  }
};
