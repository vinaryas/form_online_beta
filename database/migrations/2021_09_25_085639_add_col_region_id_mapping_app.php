<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColRegionIdMappingApp extends Migration
{

    public function up()
    {
        Schema::table('mapping_app', function (Blueprint $table) {
            $table->smallInteger('region_id')->after('id');
        });
    }

    public function down()
    {
        Schema::table('mapping_app', function (Blueprint $table) {
            $table->removeColumn('region_id');
        });
    }
}
