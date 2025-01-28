<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('maintenance_checks')) {
            Schema::create('maintenance_checks', function (Blueprint $table) {
                $table->id();
                $table->date('date');
                $table->foreignId('machine_id')->constrained()->onDelete('cascade');
                $table->foreignId('maintenance_point_id')->constrained()->onDelete('cascade');
                $table->boolean('completed')->default(false);
                $table->text('notes')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maintenance_checks');
    }
};
