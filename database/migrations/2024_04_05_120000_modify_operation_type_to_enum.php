<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    // MySQL syntax for modifying a column to ENUM
    DB::statement("ALTER TABLE `production_operations` MODIFY COLUMN `operation_type` ENUM('die_casting', 'grinding', 'packaging', 'machine_trimming', 'turning_washing') NOT NULL");
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    // Convert back to VARCHAR if needed
    DB::statement("ALTER TABLE `production_operations` MODIFY COLUMN `operation_type` VARCHAR(255) NOT NULL");
  }
};
