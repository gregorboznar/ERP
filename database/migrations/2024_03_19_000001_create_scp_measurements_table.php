<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up()
  {
    Schema::create('scp_measurements', function (Blueprint $table) {
      $table->id();
      $table->date('date');
      $table->time('time');
      $table->foreignId('user_id')->constrained();
      $table->integer('nest_number');
      $table->string('piece_id');
      $table->timestamps();
    });
  }

  public function down()
  {
    Schema::dropIfExists('scp_measurements');
  }
};
