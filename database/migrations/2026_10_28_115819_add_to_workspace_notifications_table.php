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
        Schema::table('workspace_notifications', function (Blueprint $table) {
            $table->unsignedBigInteger('notify_by')->after('read_at');
            $table->foreign('notify_by')->references('id')->on('members');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('workspace_notifications', function (Blueprint $table) {
            $table->dropForeign(['notify_by']);
            $table->dropColumn('notify_by');
        });
    }
};
