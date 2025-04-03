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
        Schema::create('die_castings', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->time('start_time');
            $table->integer('counter_start');
            $table->time('end_time')->nullable();
            $table->integer('counter_end')->nullable();
            $table->integer('good_parts_count');
            $table->decimal('technological_waste', 10, 2);
            $table->string('batch_of_material');
            $table->string('palet_number');
            $table->decimal('waste_slag_weight', 10, 2);
            $table->text('stopage_reason')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('die_castings');
    }
};
