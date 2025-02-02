<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up()
  {
    Schema::create('maintenance_check_points', function (Blueprint $table) {
      $table->id();
      $table->foreignId('maintenance_check_id')->constrained()->onDelete('cascade');
      $table->foreignId('maintenance_point_id')->constrained()->onDelete('cascade');
      $table->boolean('checked')->default(true);
      $table->timestamps();
    });
  }

  public function down()
  {
    Schema::dropIfExists('maintenance_check_points');
  }
};
