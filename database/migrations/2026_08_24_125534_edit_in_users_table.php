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
        Schema::table('users', function (Blueprint $table) {
              $table->string('password')->nullable()->change();
              $table->string('phone')->after('email')->nullable();
              $table->string('address')->after('phone')->nullable();
              $table->string('photo')->after('address')->nullable();
              $table->boolean('status')->after('photo')->nullable()->default(1);
              $table->boolean('active')->after('status')->nullable()->default(1);
              $table->string('google_id')->after('active')->nullable();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
