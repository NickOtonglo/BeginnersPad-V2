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
        Schema::create('help_tickets', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->string('topic');
            $table->longText('description');
            $table->string('status')->default('open'); //open,pending,resolved,closed,reopened
            $table->string('assigned_to')->nullable()->default(null); //admin_id
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('help_tickets');
    }
};
