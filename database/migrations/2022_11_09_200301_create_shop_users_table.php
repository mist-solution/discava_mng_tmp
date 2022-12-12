<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_users', function (Blueprint $table) {
            //$table->comment('店舗ユーザ');  // Laravel 9.14 以降
            
            $table->id()->comment('ID');
            $table->unsignedBigInteger('customer_id')->comment('顧客ID');
            $table->unsignedBigInteger('shop_id')->comment('店舗ID');
            $table->unsignedBigInteger('user_id')->comment('ユーザID');
            $table->unsignedBigInteger('authority_id')->comment('権限ID');
            // レコード更新情報
            $table->unsignedBigInteger('add_account')->comment('登録アカウント');
            $table->unsignedBigInteger('upd_account')->comment('更新アカウント');
            $table->boolean('del_flg')->default(0)->comment('削除フラグ');
            $table->datetime('created_at')->nullable()->comment('登録日時');  // 2038年問題対応 timestamp→datetime
            $table->datetime('updated_at')->nullable()->comment('更新日時');
            // インデックス情報
            $table->unique(['shop_id', 'user_id']);
            $table->index('customer_id');
            $table->index('shop_id');
            $table->index('user_id');
            $table->index('authority_id');
            // 外部キー情報
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->foreign('shop_id')->references('id')->on('shops');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('authority_id')->references('id')->on('authorities');
        });

        // テーブルコメント
        DB::statement("ALTER TABLE `shop_users` comment '店舗ユーザ'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shop_users');
    }
}
