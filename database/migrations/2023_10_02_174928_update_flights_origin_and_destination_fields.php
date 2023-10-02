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
            Schema::table('flights', function (Blueprint $table) {
                $table->string('origin', 50)->change();
                $table->string('destination', 50)->change();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('flights')) {
            Schema::table('flights', function (Blueprint $table) {
                $table->string('origin', 20)->change();
                $table->string('destination', 20)->change();
            });
        }
    }
};
