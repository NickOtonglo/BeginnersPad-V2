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
        Schema::create('logs_user_activity_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('confirmation_code')->nullable();
            $table->decimal('amount', 11, 2)->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('payment_gateway_id')->nullable();
            $table->unsignedBigInteger('payment_gateway_name')->nullable();
            $table->text('comment')->nullable();
            $table->integer('parent_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logs_user_activity_transactions');
    }
};
