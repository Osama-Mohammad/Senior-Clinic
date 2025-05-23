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
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->string('first_name', 100);
            $table->string('last_name', 100);
            $table->string('email', 150)->unique();
            $table->string('password', 255);
            $table->string('phone_number', 20)->unique()->nullable();
            // $table->string('specialization', 100)->nullable();

            $table->string('image')->nullable();

            $table->decimal('price', 8, 2)->nullable();
            $table->integer('max_daily_appointments')->nullable();
            $table->json('available_days')->nullable();
            $table->json('available_hours')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctors');
    }
};
