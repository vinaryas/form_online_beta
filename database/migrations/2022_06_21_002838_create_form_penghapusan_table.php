<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormPenghapusanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_penghapusan', function (Blueprint $table) {
            $table->id();
            $table->integer('aplikasi_id');
            $table->bigInteger('form_id');
            $table->integer('store')->nullable();
            $table->string('type');
            $table->integer('role_last_app');
            $table->integer('role_next_app');
            $table->integer('status');
            $table->integer('created_by');
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
        Schema::dropIfExists('form_penghapusan');
    }
}
