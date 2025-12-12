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
        Schema::create('timelines', function (Blueprint $table) {
            $table->id();

            // Foreign Key to Candidates (One-to-One / One-to-Few)
            $table->foreignId('candidate_id')->constrained()->unique();

            // Foreign Key to Recruiters (The recruiter managing the timeline)
            $table->foreignId('recruiter_id')->constrained('recruiters');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('timelines');
    }
};
