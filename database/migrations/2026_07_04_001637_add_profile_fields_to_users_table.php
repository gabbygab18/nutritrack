<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->decimal('height', 5, 2)->nullable();      // cm
            $table->decimal('weight', 5, 2)->nullable();      // kg
            $table->integer('age')->nullable();
            $table->string('body_type')->nullable();          // ectomorph, mesomorph, endomorph
            $table->string('goal')->nullable();               // stay, bulk, cut
            $table->string('exercise_intensity')->nullable(); // sedentary, light, moderate, heavy, athlete
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['height', 'weight', 'age', 'body_type', 'goal', 'exercise_intensity']);
        });
    }
};
