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
        Schema::create('order_infos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained();
            $table->string('MID');
            $table->string('State');
            $table->string('Status');
            $table->string('RRN');
            $table->string('ResNum');
            $table->string('RefNum');
            $table->string('SecurePan');
            $table->string('CID');
            $table->integer('Amount');
            $table->string('Wage');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_infos');
    }
};
