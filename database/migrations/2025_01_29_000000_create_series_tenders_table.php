<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
  {
    Schema::create('series_tenders', function (Blueprint $table) {
      $table->id();
      $table->integer('series_number');
      $table->string('series_name');
      $table->string('company');
      $table->string('article');
      $table->date('tender_date');
      $table->timestamps();
      $table->softDeletes();
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('series_tenders');
  }
};
