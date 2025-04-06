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
    Schema::create('production_operations', function (Blueprint $table) {
      $table->id();
      $table->date('date');
      $table->time('start_time');
      $table->integer('counter_start');
      $table->time('end_time')->nullable();
      $table->integer('counter_end');
      $table->integer('good_parts_count');
      $table->decimal('technological_waste', 10, 2);
      $table->decimal('waste', 10, 2)->nullable();
      $table->string('operation_type'); // die_casting, grinding, packaging, machine_trimming, turning_washing
      $table->string('palet_number')->nullable();
      $table->string('batch_of_material')->nullable();
      $table->decimal('waste_slag_weight', 10, 2)->nullable();
      $table->text('stopage_reason')->nullable();
      $table->text('notes')->nullable();
      $table->foreignId('series_tender_id')->constrained('series_tenders');
      $table->timestamps();
      $table->softDeletes();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('production_operations');
  }
};
