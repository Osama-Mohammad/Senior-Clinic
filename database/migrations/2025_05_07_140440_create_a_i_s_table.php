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
        Schema::create('a_i_s', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patients_id')->constrained()->cascadeOnDelete();
            $table->string('disease_name');
            $table->string('description');
            $table->json('submitted_attributes');
            $table->enum('result', ['Positive', 'Negative']);
            $table->decimal('percentage_probability', 5, 2);
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('a_i_s');
    }
};
