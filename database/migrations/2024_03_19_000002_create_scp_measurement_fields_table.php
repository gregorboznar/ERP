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
      $table->foreignId('scp_measurement_id')->constrained()->onDelete('cascade');
      $table->integer('nest_number');
      $table->integer('field_number');
      $table->decimal('value', 10, 2);
      $table->timestamps();

      // Ensure each measurement can only have one value per field number
      $table->unique(['scp_measurement_id', 'field_number']);
    });
  }

  public function down()
  {
    Schema::dropIfExists('scp_measurement_fields');
  }
};
