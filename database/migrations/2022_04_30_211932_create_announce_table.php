<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnnounceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('announce', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255);
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->text('contents');
            $table->unsignedBigInteger('announce_category_id');
            $table->boolean('approval_status');
            $table->text('approval_comment');
            $table->text('approval_account');
            $table->dateTime('approval_datetime');
            $table->boolean('del_flg');
            $table->unsignedBigInteger('add_account');
            $table->unsignedBigInteger('upd_account');
            $table->timestamps();

            $table->foreign('announce_category_id')->references('id')->on('announce_category');
            $table->foreign('add_account')->references('id')->on('users');
            $table->foreign('upd_account')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('announce');
    }
}
