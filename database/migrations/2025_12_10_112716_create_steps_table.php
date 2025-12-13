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

            $table->foreignId('timeline_id')->constrained()->onDelete('cascade');

            $table->foreignId('step_category_id')->constrained();

            $table->foreignId('recruiter_id')->constrained('recruiters');

            $table->timestamps();

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
