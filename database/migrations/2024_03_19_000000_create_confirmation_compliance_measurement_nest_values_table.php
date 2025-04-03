<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
  {
    if (!Schema::hasTable('confirmation_compliance_measurement_nest_values')) {
      Schema::create('confirmation_compliance_measurement_nest_values', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('confirmation_compliance_measurement_characteristic_id');
        $table->integer('nest_number');
        $table->decimal('measured_value', 10, 4);
        $table->timestamps();
        $table->softDeletes();

        $table->foreign('confirmation_compliance_measurement_characteristic_id')
          ->references('id')
          ->on('confirmation_compliance_measurement_characteristics')
          ->onDelete('cascade');
      });
    }
  }

  public function down(): void
  {
    Schema::dropIfExists('confirmation_compliance_measurement_nest_values');
  }
};
