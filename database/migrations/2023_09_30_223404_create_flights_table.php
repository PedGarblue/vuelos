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
        if (Schema::hasTable('flights')) {
            return;
        }
        Schema::create('flights', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name', 20);
            $table->string('origin', 20);
            $table->string('destination', 20);
            $table->dateTime('departure');
            $table->dateTime('arrival');
            $table->unsignedInteger('seats');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flights');
    }
};
