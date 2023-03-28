<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMediaFoldersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media_folders', function (Blueprint $table) {
            $table->id()->comment('ID');
            $table->unsignedBigInteger('shop_id')->comment('店舗ID');
            //フォルダ情報
            $table->unsignedBigInteger('parent_folder_id')->comment('親フォルダID');
            $table->string('name', 255)->comment('フォルダ名');
            //メディア設定
            $table->unsignedTinyInteger('media_sort')->comment('表示順');
            $table->unsignedBigInteger('media_width')->comment('画像サイズ横幅');
            $table->unsignedBigInteger('media_height')->comment('画像サイズ縦幅');
            $table->unsignedTinyInteger('media_column_num')->comment('表示カラム数');
            $table->unsignedTinyInteger('media_align')->comment('配置');
            $table->unsignedTinyInteger('media_link')->comment('リンク');
            $table->unsignedTinyInteger('media_margin')->comment('画像同士の余白の間');
            $table->unsignedTinyInteger('media_caption')->comment('キャプションの表示');
            $table->unsignedTinyInteger('media_frame_design')->comment('枠のデザイン');
            $table->string('media_frame_color', 6)->nullable()->comment('枠の色');
            $table->unsignedTinyInteger('media_shadow')->comment('影');
            $table->unsignedTinyInteger('media_hover_expand')->comment('ホバー時の画像拡大');
            $table->unsignedTinyInteger('media_hover_icon')->comment('ホバー時のアイコン');

            // レコード更新情報
            $table->unsignedBigInteger('add_account')->comment('登録アカウント');
            $table->unsignedBigInteger('upd_account')->comment('更新アカウント');
            $table->boolean('del_flg')->default(0)->comment('削除フラグ');
            $table->datetime('created_at')->nullable()->comment('登録日時');  // 2038年問題対応 timestamp→datetime
            $table->datetime('updated_at')->nullable()->comment('更新日時');

            // インデックス情報
            $table->index('shop_id');
            $table->index(['shop_id', 'parent_folder_id']);

            // 外部キー情報
            $table->foreign('shop_id')->references('id')->on('shops');
        });

         // テーブルコメント
         DB::statement("ALTER TABLE `media_folders` comment 'メディアフォルダ'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('media_folders');
    }
};
