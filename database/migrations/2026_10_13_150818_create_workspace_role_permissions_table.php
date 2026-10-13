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
        Schema::create('workspace_role_permissions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('workspace_role_id');
            $table->foreign('workspace_role_id')->references('id')->on('workspace_roles')->onDelete('cascade');
            $table->unsignedBigInteger('workspace_permission_id');
            $table->foreign('workspace_permission_id')->references('id')->on('workspace_permissions')->onDelete('cascade');
            $table->unique(['workspace_role_id', 'workspace_permission_id'],'wrp_role_permission_unique');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workspace_role_permissions');
    }
};
