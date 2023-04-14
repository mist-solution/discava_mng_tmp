<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMediaLinkUrlToMediaFoldersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('media_folders', function (Blueprint $table) {
            $table->string('media_link_url', 128)->nullable()->comment('リンク先URL');
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
            $table->dropColumn('media_link_url');
        });
    }
};