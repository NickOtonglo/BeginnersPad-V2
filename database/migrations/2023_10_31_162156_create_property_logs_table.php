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
        Schema::create('logs_user_activity_properties', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('slug')->nullable();
            $table->decimal('lat', 10, 8)->nullable();
            $table->decimal('lng', 11, 8)->nullable();
            $table->string('status')->default('unpublished')->nullable(); // unpublished,pending,approved,rejected,suspended
            $table->boolean('verified')->unsigned()->default(false)->nullable();
            $table->longText('description')->nullable();
            $table->integer('stories')->nullable(); //number of floors
            $table->string('thumbnail')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('sub_zone_id')->nullable();
            $table->longText('comment')->nullable();
            $table->integer('parent_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logs_user_activity_properties');
    }
};
