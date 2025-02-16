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
        Schema::dropIfExists('confirmation_compliance_visual_characteristics');

        Schema::create('confirmation_compliance_visual_characteristics', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('confirmation_compliance_id');
            $table->unsignedBigInteger('visual_characteristic_id');
            $table->boolean('is_compliant')->default(false);
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('confirmation_compliance_id', 'cc_visual_compliance_fk')
                ->references('id')
                ->on('confirmation_compliances')
                ->cascadeOnDelete();

            $table->foreign('visual_characteristic_id', 'cc_visual_characteristic_fk')
                ->references('id')
                ->on('visual_characteristics')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('confirmation_compliance_visual_characteristics');
    }
};
