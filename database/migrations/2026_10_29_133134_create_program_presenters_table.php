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
        Schema::create('program_presenters', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('program_id');
            $table->foreign('program_id')->references('id')->on('programs')->onDelete('cascade');
            $table->unsignedBigInteger('presenter_id');
            $table->foreign('presenter_id')->references('id')->on('members')->onDelete('cascade');
            $table->unique(['program_id', 'presenter_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('program_presenters');
    }
};
