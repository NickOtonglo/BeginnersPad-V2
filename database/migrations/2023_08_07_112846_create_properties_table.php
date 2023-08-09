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
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->decimal('lat', 10, 8);
            $table->decimal('lng', 11, 8);
            $table->string('status');
            $table->boolean('verified')->unsigned()->default(false);
            $table->longText('description')->nullable();
            $table->string('thumbnail');
            $table->integer('user_id');
            $table->integer('sub_zone_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
