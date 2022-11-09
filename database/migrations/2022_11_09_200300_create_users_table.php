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
            $table->id()->comment('ID');
            $table->unsignedBigInteger('customer_id')->comment('顧客ID');
            $table->string('login_user_id', 256)->comment('ログインユーザID');
            $table->string('mail', 256)->comment('メールアドレス');
            $table->string('name', 50)->comment('ユーザ名');
            $table->string('initial_password', 128)->comment('初期パスワード');
            $table->string('password', 128)->comment('パスワード');
            $table->unsignedBigInteger('login_fail_count')->comment('ログイン試行回数');
            $table->timestamp('email_verified_at')->nullable()->comment('メールアドレス変更日時');
            // トークン保持情報
            $table->rememberToken();
            // レコード更新情報
            $table->unsignedBigInteger('add_account');
            $table->unsignedBigInteger('upd_account');
            $table->boolean('del_flg')->default(0);
            $table->timestamps();  //created_at, updated_at
            // インデックス情報
            $table->unique('login_user_id');
            $table->unique('mail');
            // 外部キー情報
            $table->foreign('customer_id')->references('id')->on('customers');
        });
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
