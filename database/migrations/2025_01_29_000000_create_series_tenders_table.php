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
      $table->string('series_number', 20);
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
