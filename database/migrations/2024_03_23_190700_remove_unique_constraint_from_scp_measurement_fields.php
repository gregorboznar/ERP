<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up()
  {
    Schema::table('scp_measurement_fields', function (Blueprint $table) {
      $table->dropUnique(['scp_measurement_id', 'field_number']);
    });
  }

  public function down()
  {
    Schema::table('scp_measurement_fields', function (Blueprint $table) {
      $table->unique(['scp_measurement_id', 'field_number']);
    });
  }
};
