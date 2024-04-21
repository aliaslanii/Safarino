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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->string('mobile')->nullable();
            $table->string('ordernumber')->uniqid();
            $table->integer('Amount');
            $table->boolean('is_payed')->default(0);
            $table->enum('Status',['Expectation','Final','Cancel']);
            $table->enum('type',['Airplane','Train']);
            $table->foreignId('trainticket_id')->nullable()->constrained('train_tickets');
            $table->foreignId('airplanetickets_id')->nullable()->constrained('airplane_tickets');
            $table->text('Description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
