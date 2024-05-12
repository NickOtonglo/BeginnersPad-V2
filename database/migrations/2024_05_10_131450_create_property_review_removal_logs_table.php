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
        Schema::create('logs_user_activity_property_review_removal', function (Blueprint $table) {
            $table->id();
            $table->longText('review')->nullable();
            $table->decimal('rating', 3, 2)->nullable();
            $table->integer('author_id')->nullable();
            $table->integer('property_id')->nullable();
            $table->string('removal_reason')->nullable();
            $table->longText('reason_details')->nullable();
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
        Schema::dropIfExists('property_review_removal_logs');
    }
};
