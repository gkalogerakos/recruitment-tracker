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
        Schema::create('steps', function (Blueprint $table) {
            $table->id();

            // Foreign Key to Timeline
            $table->foreignId('timeline_id')->constrained();

            // Foreign Key to StepCategory
            $table->foreignId('step_category_id')->constrained();

            // Foreign Key to Recruiter who created the step
            $table->foreignId('recruiter_id')->constrained('recruiters');

            $table->timestamps();

            // **CONSTRAINT:** Ensure a Step Category can only be used once per Timeline
            $table->unique(['timeline_id', 'step_category_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('steps');
    }
};
