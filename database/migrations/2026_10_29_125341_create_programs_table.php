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
        Schema::create('programs', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->string('icon')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedBigInteger('program_type_id');
            $table->foreign('program_type_id')->references('id')->on('program_types')->onDelete('cascade');
            $table->index('program_type_id');
            $table->index('slug');
            $table->index('name');
            $table->enum('broadcast_mode', ['live', 'recorded'])->default('live');
            $table->index('broadcast_mode');
            $table->enum('broadcast_schedule', ['daily', 'weekly', 'monthly'])->default('daily');
            $table->index('broadcast_schedule');
            $table->unsignedBigInteger('default_duration_minutes')->default(60);
            $table->enum('status', ['pending', 'active', 'inactive'])->default('active');
            $table->index('status');
            $table->unsignedBigInteger('workspace_id');
            $table->foreign('workspace_id')->references('id')->on('workspaces')->onDelete('cascade');
            $table->index('workspace_id');
            $table->unsignedBigInteger('created_by');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->index('created_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('programs');
    }
};
