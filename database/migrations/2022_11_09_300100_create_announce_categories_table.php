<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnnounceCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('announce_categories', function (Blueprint $table) {
            //$table->comment('お知らせカテゴリ');  // Laravel 9.14 以降

            $table->id()->comment('ID');
            $table->unsignedBigInteger('shop_id')->comment('店舗ID');
            $table->string('category_name',128)->comment('カテゴリ名');
            $table->string('description',255)->nullable()->comment('カテゴリ説明');
            $table->string('icon',128)->nullable()->comment('お知らせアイコン');
            // レコード更新情報
            $table->unsignedBigInteger('add_account')->comment('登録アカウント');
            $table->unsignedBigInteger('upd_account')->comment('更新アカウント');
            $table->boolean('del_flg')->default(0)->comment('削除フラグ');
            $table->datetime('created_at')->nullable()->comment('登録日時');  // 2038年問題対応 timestamp→datetime
            $table->datetime('updated_at')->nullable()->comment('更新日時');
            // インデックス情報
            $table->index('shop_id');
            // 外部キー情報
            $table->foreign('shop_id')->references('id')->on('shops');
        });

        // テーブルコメント
        DB::statement("ALTER TABLE `announce_categories` comment 'お知らせカテゴリ'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('announce_categories');
    }
}
