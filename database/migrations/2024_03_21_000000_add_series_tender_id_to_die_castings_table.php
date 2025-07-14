<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
  {
    // No operation needed, column already exists in table creation
  }

  public function down(): void
  {
    Schema::table('die_castings', function (Blueprint $table) {
      $table->dropForeign(['series_tender_id']);
      $table->dropColumn('series_tender_id');
    });
  }
};
