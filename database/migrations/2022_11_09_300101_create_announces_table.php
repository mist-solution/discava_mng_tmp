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
            $table->unsignedBigInteger('shop_id');
            $table->unsignedBigInteger('announce_category_id');
            $table->dateTime('start_date');
            $table->dateTime('end_date')->nullable();
            $table->string('title', 256);
            $table->string('thumbnail_img_path', 128);
            $table->text('contents');
            // 承認ステータス情報
            $table->unsignedTinyInteger('approval_status')->default(0);
            $table->text('approval_account')->nullable();
            $table->dateTime('approval_datetime')->nullable();
            $table->string('remand_comment', 512)->nullable();
            // レコード更新情報
            $table->unsignedBigInteger('add_account');
            $table->unsignedBigInteger('upd_account');
            $table->boolean('del_flg')->default(0);
            $table->timestamps();  //created_at, updated_at
            // インデックス情報
            $table->index('shop_id');
            // 外部キー情報
            $table->foreign('announce_category_id')->references('id')->on('announce_categories');
            $table->foreign('shop_id')->references('id')->on('shops');
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
