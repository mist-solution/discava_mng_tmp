<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnnounceAttachmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('announce_attachments', function (Blueprint $table) {
            //$table->comment('お知らせ添付ファイル');  // Laravel 9.14 以降

            $table->id()->comment('ID');
            $table->unsignedBigInteger('shop_id')->comment('店舗ID');
            $table->unsignedBigInteger('announce_id')->comment('お知らせID');
            $table->string('img_path', 128)->comment('画像パス');
            $table->string('img_filename', 128)->comment('画像ファイル名');
            // レコード更新情報
            $table->unsignedBigInteger('add_account')->comment('登録アカウント');
            $table->unsignedBigInteger('upd_account')->comment('更新アカウント');
            $table->boolean('del_flg')->default(0)->comment('削除フラグ');
            $table->datetime('created_at')->nullable()->comment('登録日時');  // 2038年問題対応 timestamp→datetime
            $table->datetime('updated_at')->nullable()->comment('更新日時');
            // インデックス情報
            $table->index('shop_id');
            $table->index('announce_id');
            // 外部キー情報
            $table->foreign('shop_id')->references('id')->on('shops');
            $table->foreign('announce_id')->references('id')->on('announces');
        });

        // テーブルコメント
        DB::statement("ALTER TABLE `announce_attachments` comment 'お知らせ添付ファイル'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('announce_attachments');
    }
}
