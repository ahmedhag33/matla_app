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
        Schema::table('episodes', function (Blueprint $table) {
            $table->unsignedBigInteger('created_by')->change();
            $table->dropForeign('episodes_created_by_foreign');

            $table->foreign('created_by', 'episodes_created_by_member_foreign')
                ->references('id')
                ->on('members')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('episodes', function (Blueprint $table) {
            //
        });
    }
};
