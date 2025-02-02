<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('machine_maintenance_point', function (Blueprint $table) {
            $table->id();
            $table->foreignId('machine_id')->constrained()->onDelete('cascade');
            $table->timestamps();

            // Add unique constraint to prevent duplicates
            $table->unique(['machine_id']);
        });

        // Remove the machine_id column from maintenance_points table
        Schema::table('maintenance_points', function (Blueprint $table) {
            $table->dropForeign(['machine_id']);
            $table->dropColumn('machine_id');
        });
    }

    public function down()
    {
        // Add back the machine_id column to maintenance_points table
        Schema::table('maintenance_points', function (Blueprint $table) {
            $table->foreignId('machine_id')->nullable()->constrained();
        });

        Schema::dropIfExists('machine_maintenance_point');
    }
};
