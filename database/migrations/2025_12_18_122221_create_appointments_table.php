<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('patient_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('doctor_name');
            $table->date('appointment_date');
            $table->time('appointment_time');

            $table->string('status')->default('booked');
            $table->text('notes')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->unique(
                ['patient_id',
                 'appointment_date', 
                 'appointment_time'
            ], 'unique_patient_slot'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
