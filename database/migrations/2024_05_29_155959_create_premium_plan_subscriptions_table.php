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
        Schema::create('premium_plan_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('period'); //days
            $table->dateTime('activated_at');
            $table->dateTime('expires_at');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('premium_plan_id');
            $table->unique(['user_id', 'premium_plan_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('premium_plan_subscriptions');
    }
};
