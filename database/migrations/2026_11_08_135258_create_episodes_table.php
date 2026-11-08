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
        Schema::create('episodes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('program_id');
            $table->foreign('program_id')->references('id')->on('programs')->onDelete('cascade');
            $table->unsignedInteger('episode_number');
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('slug')->unique();
            $table->date('air_date');
            $table->time('air_time');
            $table->unsignedBigInteger('duration');
            $table->boolean('reminder_before_air')->default(false);
            $table->timestamp('reminder_time')->nullable();
            $table->enum('status', ['draft', 'in_preparation', 'under_review', 'approved', 'scheduled', 'on_air', 'completed', 'cancelled', 'postponed'])->default('draft');
            $table->boolean('is_active')->default(true);
            $table->unsignedBigInteger('created_by');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->unique(['program_id', 'episode_number']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('episodes');
    }
};
