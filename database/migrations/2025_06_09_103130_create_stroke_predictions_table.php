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
        Schema::create('stroke_predictions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ai_model_id')->constrained()->cascadeOnDelete();
            $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
            $table->foreignId('doctor_id')->constrained()->cascadeOnDelete();
            $table->json('submitted_attributes'); // raw input
            $table->enum('result', ['Stroke', 'No Stroke']);
            $table->decimal('percentage_probability', 5, 2); // e.g. 98.75
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stroke_predictions');
    }
};
