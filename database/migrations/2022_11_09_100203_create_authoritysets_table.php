<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuthoritySetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('authority_sets', function (Blueprint $table) {
            //$table->comment('権限セット');  // Laravel 9.14 以降

            $table->id()->comment('ID');
            $table->unsignedBigInteger('authority_id')->comment('セットID');
            $table->unsignedBigInteger('mate_function_id')->comment('機能ID');
            $table->unsignedTinyInteger('function_auth_flg')->comment('機能権限フラグ');
            $table->unsignedTinyInteger('create_auth_flg')->comment('登録権限フラグ');
            $table->unsignedTinyInteger('read_auth_flg')->comment('表示権限フラグ');
            $table->unsignedTinyInteger('update_auth_flg')->comment('編集権限フラグ');
            $table->unsignedTinyInteger('delete_auth_flg')->comment('削除権限フラグ');
            $table->unsignedTinyInteger('request_auth_flg')->comment('申請権限フラグ');
            $table->unsignedTinyInteger('approval_auth_flg')->comment('承認権限フラグ');
            // レコード更新情報
            $table->unsignedBigInteger('add_account')->comment('登録アカウント');
            $table->unsignedBigInteger('upd_account')->comment('更新アカウント');
            $table->boolean('del_flg')->default(0)->comment('削除フラグ');
            $table->datetime('created_at')->nullable()->comment('登録日時');  // 2038年問題対応 timestamp→datetime
            $table->datetime('updated_at')->nullable()->comment('更新日時');
            // インデックス情報
            $table->unique(['authority_id', 'mate_function_id']);
            // 外部キー情報
            $table->foreign('mate_function_id')->references('id')->on('mate_functions');
        });

        // テーブルコメント
        DB::statement("ALTER TABLE `authority_sets` comment '権限セット'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('authority_sets');
    }
}
