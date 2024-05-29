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
        Schema::create('logs_user_activity_premium_plan_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('period')->nullable();
            $table->dateTime('activated_at')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('premium_plan_id')->nullable();
            $table->string('premium_plan_name')->nullable();
            $table->string('premium_plan_minimum_period')->nullable();
            $table->decimal('premium_plan_price', 11, 2)->nullable();
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
        Schema::dropIfExists('premium_plan_subscription_logs');
    }
};
