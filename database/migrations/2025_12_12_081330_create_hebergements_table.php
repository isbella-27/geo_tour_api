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
        Schema::create('hebergements', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('location', 100);
            $table->decimal('rating', 2, 1)->nullable();
            $table->string('price', 50);
            $table->text('description');
            $table->json('features')->nullable();
            $table->string('image')->nullable();
            $table->enum('type', ['Hôtels', 'Lodges Écologiques', 'Auberges', 'Stations balnéaires']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hebergements');
    }
};
