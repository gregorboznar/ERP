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
        Schema::create('confirmation_compliance_measurement_characteristics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('confirmation_compliance_id')->constrained()->cascadeOnDelete();
            $table->foreignId('measurement_characteristic_id')->constrained()->cascadeOnDelete();
            $table->decimal('measured_value', 10, 4);
            $table->boolean('is_compliant')->default(false);
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
        Schema::dropIfExists('confirmation_compliance_measurement_characteristics');
    }
};
