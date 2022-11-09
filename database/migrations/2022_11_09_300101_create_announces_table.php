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
            $table->id()->comment('ID');
            $table->unsignedBigInteger('shop_id')->comment('店舗ID');
            $table->unsignedBigInteger('announce_category_id')->comment('お知らせカテゴリID');
            $table->dateTime('start_date')->comment('掲載開始日');
            $table->dateTime('end_date')->nullable()->comment('掲載終了日');
            $table->string('title', 256)->comment('タイトル');
            $table->string('thumbnail_img_path', 128)->comment('サムネイル画像パス');
            $table->text('contents')->comment('内容');
            // 承認ステータス情報
            $table->unsignedTinyInteger('approval_status')->default(0)->comment('承認ステータス');
            $table->text('approval_account')->nullable()->comment('承認アカウント');
            $table->dateTime('approval_datetime')->nullable()->comment('承認日時');
            $table->string('remand_comment', 512)->nullable()->comment('差戻しコメント');
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
