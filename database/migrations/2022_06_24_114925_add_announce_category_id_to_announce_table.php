<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAnnounceCategoryIdToAnnounceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('announce', function (Blueprint $table) {
            $table->unsignedBigInteger('announce_category_id')->after('contents');
            $table->foreign('announce_category_id')->references('id')->on('announce_category');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('announce', function (Blueprint $table) {
            $table->dropColumn('announce_category_id');
        });
    }
}
