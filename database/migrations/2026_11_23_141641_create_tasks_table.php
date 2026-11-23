<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('episode_id');
            $table->foreign('episode_id')->references('id')->on('episodes')->onDelete('cascade');
            $table->enum('task_context', ['episode', 'segment']);
            $table->unsignedBigInteger('segment_id')->nullable();
            $table->foreign('segment_id')->references('id')->on('segments')->onDelete('cascade');
            $table->enum('content_type', ['news', 'topics','researchs']);
            $table->unsignedBigInteger('content_id');
            $table->string('title');
            $table->longText('description');
            $table->json('requirements');
            $table->string('source')->nullable();
            $table->unsignedBigInteger('assigned_id');
            $table->foreign('assigned_id')->references('id')->on('members')->onDelete('cascade');
            $table->enum('status', ['pending', 'in_progress', 'completed']);
            $table->enum('priority', ['low', 'medium', 'high']);
            $table->timestamp('due_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
