<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRjServerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rj_server', function (Blueprint $table) {
            $table->id();
            $table->integer('cashnum');
            $table->string('nama');
            $table->string('password');
            $table->integer('roles');
            $table->integer('store')->nullable();
            $table->string('status');
            $table->integer('acc');
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
        Schema::dropIfExists('rj_server');
    }
}
