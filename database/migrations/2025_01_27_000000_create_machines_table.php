<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
  {
    Schema::create('machines', function (Blueprint $table) {
      $table->id();
      $table->string('machine_type');
      $table->string('type');
      $table->date('year_of_manufacture');
      $table->string('manufacturer');
      $table->string('inventory_number')->unique();
      $table->date('control_period');
      $table->timestamps();
      $table->softDeletes();
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('machines');
  }
};
