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
        Schema::create('entries', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('meal');
            $table->decimal('servings', 8, 2)->default(1);
            $table->string('serving_unit')->default('serving');
            $table->decimal('per_calories', 10, 2)->default(0);
            $table->decimal('per_protein', 10, 2)->default(0);
            $table->decimal('per_carbs', 10, 2)->default(0);
            $table->decimal('per_fat', 10, 2)->default(0);
            $table->decimal('calories', 10, 2)->default(0);
            $table->decimal('protein', 10, 2)->default(0);
            $table->decimal('carbs', 10, 2)->default(0);
            $table->decimal('fat', 10, 2)->default(0);
            $table->longText('photo')->nullable();
            $table->date('date');
            $table->unsignedBigInteger('timestamp');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entries');
    }
};
