<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            //$table->comment('ユーザ');  // Laravel 9.14 以降

            $table->id()->comment('ID');
            $table->unsignedBigInteger('customer_id')->comment('顧客ID');
            $table->string('login_user_id', 256)->comment('ログインユーザID');
            $table->string('email', 256)->comment('メールアドレス');
            $table->string('name', 50)->comment('ユーザ名');
            $table->string('initial_password', 128)->comment('初期パスワード');
            $table->string('password', 128)->comment('パスワード');
            $table->datetime('email_verified_at')->nullable()->comment('メールアドレス変更日時');
            // トークン保持情報
            $table->rememberToken();
            // レコード更新情報
            $table->unsignedBigInteger('add_account')->comment('登録アカウント');
            $table->unsignedBigInteger('upd_account')->comment('更新アカウント');
            $table->boolean('del_flg')->default(0)->comment('削除フラグ');
            $table->datetime('created_at')->nullable()->comment('登録日時');  // 2038年問題対応 timestamp→datetime
            $table->datetime('updated_at')->nullable()->comment('更新日時');
            // インデックス情報
            $table->unique('login_user_id');
            $table->unique('email');
            $table->index('customer_id');
            $table->index('name');
            // 外部キー情報
            $table->foreign('customer_id')->references('id')->on('customers');
        });

        // テーブルコメント
        DB::statement("ALTER TABLE `users` comment 'ユーザ'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
