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
        Schema::create('passenger_airplanetickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('passenger_id')->constrained();
            $table->foreignId('airplaneticket_id')->constrained('airplane_tickets');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('passenger_airplanetickets');
    }
};
