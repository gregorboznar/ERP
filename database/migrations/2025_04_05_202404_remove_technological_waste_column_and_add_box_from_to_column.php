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
        Schema::table('grindings', function (Blueprint $table) {
            $table->dropColumn('technological_waste');
            $table->dropColumn('batch_of_material');
            $table->dropColumn('waste_slag_weight');
            $table->string('box_from_to')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('grindings', function (Blueprint $table) {
            $table->decimal('technological_waste', 10, 2)->nullable();
            $table->string('batch_of_material')->nullable();
            $table->decimal('waste_slag_weight', 10, 2)->nullable();
            $table->dropColumn('box_from_to');
        });
    }
};
