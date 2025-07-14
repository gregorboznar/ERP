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
        if (!Schema::hasTable('confirmation_compliance_measurement_characteristics')) {
            Schema::create('confirmation_compliance_measurement_characteristics', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('confirmation_compliance_id');
                $table->unsignedBigInteger('measurement_characteristic_id');
                $table->decimal('measured_value', 10, 4);
                $table->boolean('is_compliant')->default(false);
                $table->text('notes')->nullable();
                $table->timestamps();
                $table->softDeletes();

                $table->foreign('confirmation_compliance_id', 'fk_ccmc_cc_id')
                    ->references('id')->on('confirmation_compliances')->onDelete('cascade');
                $table->foreign('measurement_characteristic_id', 'fk_ccmc_mc_id')
                    ->references('id')->on('measurement_characteristics')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('confirmation_compliance_measurement_characteristics');
    }
};
