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
        Schema::table('member_verfication_codes', function (Blueprint $table) {
            $table->unsignedBigInteger('member_id')->nullable()->change();
            $table->string('email')->nullable()->after('member_id');
            $table->text('code')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('member_verfication_codes', function (Blueprint $table) {
            //
        });
    }
};
