<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogAppBuatIdTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logAppBuatId', function (Blueprint $table) {
            $table->id();
            $table->integer('form_pembuatan_id');
            $table->biginteger('user_id');
            $table->biginteger('nik');
            $table->string('name');
            $table->biginteger('role_id');
            $table->biginteger('region_id');
            $table->string('status');
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
        Schema::dropIfExists('logAppBuatId');
    }
}
