<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
  {
    Schema::create('measurement_characteristics', function (Blueprint $table) {
      $table->id();
      $table->string('name');
      $table->string('unit')->nullable();
      $table->float('nominal_value')->nullable();
      $table->float('tolerance')->nullable();
      $table->timestamps();
      $table->softDeletes();
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('measurement_characteristics');
  }
};
