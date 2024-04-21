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
        Schema::create('airplane_tickets', function (Blueprint $table) {
            $table->id();
            $table->double('adultPrice');
            $table->date('arrivalDate');
            $table->time('arrivalTime');
            $table->date('departureDate');
            $table->time('departureTime');
            $table->integer('capacity');
            $table->string('aircraft');
            $table->integer('flightNumber');
            $table->integer('maxAllowedBaggage');
            $table->boolean('isCompleted')->default(false);
            $table->foreignId('airline_id')->constrained();
            $table->foreignId('airport_id')->constrained();
            $table->foreignId('origin')->constrained('cities');
            $table->foreignId('destination')->constrained('cities');
            $table->enum('type',['Charter','Systemic']);
            $table->enum('cabinclass',['Economy','Business','Firstclass']);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('airplane_tickets');
    }
};
