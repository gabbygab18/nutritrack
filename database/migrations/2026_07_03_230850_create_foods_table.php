<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('foods', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('name_normalized')->index();
            $table->json('aliases')->nullable(); // alt spellings, e.g. ["adobong manok"]
            $table->string('category')->nullable(); // Ulam, Rice, Soup, Snack, Dessert, Breakfast
            $table->string('serving_description')->default('1 serving');
            $table->decimal('serving_grams', 8, 2)->nullable();
            $table->decimal('calories', 8, 2);
            $table->decimal('protein', 8, 2);
            $table->decimal('carbs', 8, 2);
            $table->decimal('fat', 8, 2);
            $table->string('source')->default('estimated'); // 'FNRI PFCT' once verified
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('foods');
    }
};
