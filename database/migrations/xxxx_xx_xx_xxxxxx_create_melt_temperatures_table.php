<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMeltTemperaturesTable extends Migration
{
  public function up()
  {
    Schema::create('melt_temperatures', function (Blueprint $table) {
      $table->id();
      $table->foreignId('user_id')->constrained()->nullable(); // Foreign key to users table
      $table->decimal('temperature', 8, 2); // Adjust precision as needed
      $table->timestamp('recorded_at')->useCurrent(); // Default to current timestamp
      $table->softDeletes(); // Soft deletes
      $table->timestamps(); // Created at and updated at
    });
  }

  public function down()
  {
    Schema::dropIfExists('melt_temperatures');
  }
}
