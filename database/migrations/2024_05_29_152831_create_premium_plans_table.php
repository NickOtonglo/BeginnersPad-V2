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
        Schema::create('premium_plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->longText('description')->nullable();
            $table->string('status')->default('active'); // active, inactive
            $table->unsignedBigInteger('minimum_days');
            $table->decimal('price', 11, 2)->nullable();
            $table->timestamps();
        });

        Schema::create('premium_plan_role', function (Blueprint $table) {
            $table->integer('premium_plan_id');
            $table->integer('role_id');
            $table->primary(['premium_plan_id', 'role_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('premium_plans');
    }
};
