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
        Schema::create('listings', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('availability');
            $table->text('description');
            $table->json('images');
            $table->decimal('price', 10, 2);
            $table->decimal('living_space', 10, 2);
            $table->string('address');
            $table->integer('completion_year');
            $table->integer('floors');
            $table->integer('bedrooms');
            $table->integer('bathrooms');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('listings');
    }
};
