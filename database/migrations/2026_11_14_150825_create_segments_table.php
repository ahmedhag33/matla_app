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
        Schema::create('segments', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('slug')->unique();
            $table->enum('type', [
                'opening',
                'news',
                'report',
                'analysis',
                'interview',
                'live_call',
                'statistics',
                'break',
                'closing',
            ]);
            $table->unsignedBigInteger('segment_number');
            $table->unsignedBigInteger('duration');
            $table->unsignedBigInteger('episode_id');
            $table->foreign('episode_id')->references('id')->on('episodes')->onDelete('cascade');
            $table->unique(['episode_id', 'segment_number']);
            $table->index('episode_id');
            $table->enum('status', [
                'draft',
                'in_progress',
                'ready',
                'archived',
            ])->default('draft');
            $table->boolean('is_active')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('segments');
    }
};
