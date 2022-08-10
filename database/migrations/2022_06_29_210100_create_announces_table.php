<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnnouncesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('announces', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255);
            $table->unsignedBigInteger('announce_category_id');
            $table->dateTime('start_date');
            $table->dateTime('end_date')->nullable();
            $table->text('contents');
            $table->unsignedTinyInteger('approval_status')->default(0);
            $table->text('approval_comment')->nullable();
            $table->text('approval_account')->nullable();
            $table->dateTime('approval_datetime')->nullable();
            $table->boolean('del_flg')->default(false);
            $table->unsignedBigInteger('add_account');
            $table->unsignedBigInteger('upd_account');
            $table->timestamps();

            $table->foreign('announce_category_id')->references('id')->on('announce_categories');
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
        Schema::dropIfExists('announces');
    }
}
