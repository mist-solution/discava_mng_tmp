<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddKaisouToMediaFoldersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('media_folders', function (Blueprint $table) {
            $table->unsignedTinyInteger('kaisou')->comment('階層');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('media_folders', function (Blueprint $table) {
            $table->dropColumn('kaisou');
        });
    }
};
