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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->text("first_phone")->nullable();
            $table->text("second_phone")->nullable();
            $table->text("email")->nullable();
            $table->text("address")->nullable();
            $table->text("instagram")->nullable();
            $table->text("whatsapp")->nullable();
            $table->text("linkdin")->nullable();
            $table->text("facebook")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
