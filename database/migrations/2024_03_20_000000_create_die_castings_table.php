<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
  {
    if (!Schema::hasTable('die_castings')) {
      Schema::create('die_castings', function (Blueprint $table) {
        $table->id();
        $table->date('date');
        $table->dateTime('start_time');
        $table->integer('counter_start');
        $table->dateTime('end_time');
        $table->integer('counter_end');
        $table->integer('good_parts_count');
        $table->decimal('technological_waste', 10, 2);
        $table->string('batch_of_material')->nullable();
        $table->string('palet_number')->nullable();
        $table->decimal('waste_slag_weight', 10, 2)->nullable();
        $table->string('stopage_reason')->nullable();
        $table->text('notes')->nullable();
        $table->unsignedBigInteger('series_tender_id')->nullable();
        $table->timestamps();
        $table->softDeletes();

        $table->foreign('series_tender_id')->references('id')->on('series_tenders')->onDelete('set null');
      });
    }
  }

  public function down(): void
  {
    Schema::dropIfExists('die_castings');
  }
};
