<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('scheduler_settings', function (Blueprint $table) {
            $table->id();
            $table->string('day_of_week'); // sun, mon, etc
            $table->integer('hour');       // 0 - 23
            $table->integer('minute');     // 0 - 59
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scheduler_settings');
    }
};
