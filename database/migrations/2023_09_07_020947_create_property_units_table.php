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
        Schema::create('property_units', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->longText('description')->nullable();
            $table->decimal('price', 11, 2)->nullable();
            $table->decimal('init_deposit', 11, 2)->nullable();
            $table->integer('init_deposit_period')->nullable(); // months
            $table->integer('story')->nullable(); // floor number
            $table->integer('floor_area')->nullable();
            $table->integer('bathrooms')->nullable();
            $table->integer('bedrooms')->nullable();
            $table->longText('disclaimer')->nullable();
            $table->string('status')->default('inactive'); // active,inactive,occupied
            $table->string('thumbnail')->nullable();
            $table->integer('property_id');
            // $table->unique(['slug', 'property_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('property_units');
    }
};
