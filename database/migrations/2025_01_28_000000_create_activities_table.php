<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
  {
    Schema::create('activities', function (Blueprint $table) {
      $table->id();
      $table->foreignId('machine_id')->constrained()->onDelete('cascade');
      $table->text('activity_description');
      $table->string('lubrication_product');
      $table->string('frequency', 50);
      $table->string('check_method');
      $table->timestamps();
      $table->softDeletes();
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('activities');
  }
};
