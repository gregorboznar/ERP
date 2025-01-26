<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('material_receipts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->date('delivery_date');
            $table->string('delivery_note_number');
            $table->string('batch_number');
            $table->decimal('weight', 8, 2);
            $table->decimal('total', 10, 2);
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('material_id');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('material_id')->references('id')->on('materials')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('material_receipts');
    }
};
