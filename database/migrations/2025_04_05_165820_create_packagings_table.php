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
        Schema::create('packagings', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->time('start_time');
            $table->integer('counter_start');
            $table->time('end_time')->nullable();
            $table->integer('counter_end')->nullable();
            $table->integer('good_parts_count');
            $table->decimal('technological_waste', 10, 2);
            $table->decimal('waste', 10, 2);
            $table->string('palet_number');
            $table->string('series_tender_id');
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
        Schema::dropIfExists('packagings');
    }
};
