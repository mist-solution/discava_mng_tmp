<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMediaAttachmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media_attachments', function (Blueprint $table) {
            $table->id()->comment('ID');
            $table->unsignedBigInteger('shop_id')->comment('店舗ID');

            //フォルダ情報
            $table->unsignedBigInteger('media_folder_id')->comment('メディアフォルダID');

            //画像設定
            $table->string('img_path', 128)->comment('画像パス');
            $table->string('img_filename', 128)->comment('画像ファイル名');
            $table->string('img_fileformat', 64)->comment('ファイル形式');
            $table->unsignedBigInteger('img_filesize')->comment('ファイル容量');
            $table->unsignedBigInteger('img_height')->comment('サイズ縦');
            $table->unsignedBigInteger('img_width')->comment('サイズ横');
            $table->string('img_caption', 255)->comment('キャプション');
            $table->string('img_memo', 255)->nullable()->comment('メモ');
            $table->string('img_alt', 255)->nullable()->comment('代替テキスト');

            //画像表示順
            $table->unsignedBigInteger('img_sortno')->nullable()->comment('画像表示順');

            // レコード更新情報
            $table->unsignedBigInteger('add_account')->comment('登録アカウント');
            $table->unsignedBigInteger('upd_account')->comment('更新アカウント');
            $table->boolean('del_flg')->default(0)->comment('削除フラグ');
            $table->datetime('created_at')->nullable()->comment('登録日時');  // 2038年問題対応 timestamp→datetime
            $table->datetime('updated_at')->nullable()->comment('更新日時');

            // インデックス情報
            $table->index('shop_id');
            $table->index('media_folder_id');
            $table->index(['shop_id', 'media_folder_id']);

            // 外部キー情報
            $table->foreign('shop_id')->references('id')->on('shops');
            $table->foreign('media_folder_id')->references('id')->on('media_folders');
        });

        // テーブルコメント
        DB::statement("ALTER TABLE `media_attachments` comment 'メディア添付ファイル'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('media_attachments');
    }
};
