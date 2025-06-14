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
        Schema::create('simulation_configs', function (Blueprint $table) {
            $table->id();
            $table->integer('frequency_minutes')->default(15);
            $table->integer('baseline_aqi')->default(50);
            $table->integer('variation_range')->default(20);
            $table->enum('status', ['running', 'stopped'])->default('stopped');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('simulation_configs');
    }
};
