<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up()
  {
    // First, drop the foreign key constraint
    Schema::table('machine_maintenance_point', function (Blueprint $table) {
      $table->dropForeign(['machine_id']);
    });

    // Then drop the unique constraint
    Schema::table('machine_maintenance_point', function (Blueprint $table) {
      $table->dropUnique(['machine_id']);
    });

    // Re-add the foreign key constraint
    Schema::table('machine_maintenance_point', function (Blueprint $table) {
      $table->foreign('machine_id')->references('id')->on('machines')->onDelete('cascade');
    });

    // Add maintenance_point_id if it doesn't exist
    Schema::table('machine_maintenance_point', function (Blueprint $table) {
      if (!Schema::hasColumn('machine_maintenance_point', 'maintenance_point_id')) {
        $table->foreignId('maintenance_point_id')->constrained()->onDelete('cascade');
      }
      // Add a unique constraint on both columns to prevent duplicates
      $table->unique(['machine_id', 'maintenance_point_id']);
    });
  }

  public function down()
  {
    Schema::table('machine_maintenance_point', function (Blueprint $table) {
      // Drop the composite unique constraint
      $table->dropUnique(['machine_id', 'maintenance_point_id']);

      // Drop the foreign keys
      $table->dropForeign(['maintenance_point_id']);
      $table->dropForeign(['machine_id']);

      // Re-add the original constraint and foreign key
      $table->unique(['machine_id']);
      $table->foreign('machine_id')->references('id')->on('machines')->onDelete('cascade');
    });
  }
};
