<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
  {
    Schema::create('confirmation_compliance_measurement_nest_values', function (Blueprint $table) {
      $table->id();
      $table->foreignId('confirmation_compliance_measurement_characteristic_id')
        ->constrained('confirmation_compliance_measurement_characteristics')
        ->cascadeOnDelete();
      $table->integer('nest_number');
      $table->decimal('measured_value', 10, 4);
      $table->timestamps();
      $table->softDeletes();
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('confirmation_compliance_measurement_nest_values');
  }
};
