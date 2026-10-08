<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogfileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logfile', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->ipAddress('visitor')->nullable();
            $table->date('login_date')->nullable();
            $table->time('login_time')->nullable();
            $table->date('logout_date')->nullable();
            $table->time('logout_time')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('logfile');
    }
}
