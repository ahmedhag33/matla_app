<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::dropIfExists('employees_permissions');
        // drop table
        Schema::dropIfExists('permissions');
        // drop table
        Schema::dropIfExists('logfile');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees_permissions');
        // drop table
        Schema::dropIfExists('permissions');
        // drop table
        Schema::dropIfExists('logfile');
    }
};
