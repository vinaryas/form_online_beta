<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApprovalPembuatanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('approval_pembuatan', function (Blueprint $table) {
            $table->id();
            $table->integer('form_pembuatan_id');
            $table->biginteger('approved_by');
            $table->biginteger('approver_nik');
            $table->string('approver_name');
            $table->biginteger('approver_role_id');
            $table->biginteger('approver_region_id');
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
        Schema::dropIfExists('approval_pembuatan');
    }
}
