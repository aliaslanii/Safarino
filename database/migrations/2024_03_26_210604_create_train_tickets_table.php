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
        Schema::create('train_tickets', function (Blueprint $table) {
            $table->id();
            $table->double('adultPrice');
            $table->date('arrivalDate');
            $table->time('arrivalTime');
            $table->date('departureDate');
            $table->time('departureTime');
            $table->integer('capacity');
            $table->string('trainnumber');
            $table->boolean('isCompleted')->default(false);
            $table->foreignId('railcompanie_id')->constrained();
            $table->foreignId('origin')->constrained('cities');
            $table->foreignId('destination')->constrained('cities');
            $table->enum('type',['4-seater-coupe','6-seater-coupe','4-row-hall']); 
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('train_tickets');
    }
};
