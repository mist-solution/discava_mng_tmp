<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSystemAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('system_admins', function (Blueprint $table) {
            //$table->comment('システム管理者');  // Laravel 9.14 以降
            
            $table->id()->comment('ID');
            $table->string('login_user_id', 255)->comment('ログインユーザID');
            $table->string('mail', 255)->comment('メールアドレス');
            $table->string('name', 50)->comment('システム管理者名');
            $table->string('initial_password', 128)->comment('初期パスワード');
            $table->string('password', 128)->comment('パスワード');
            // レコード更新情報
            $table->unsignedBigInteger('add_account')->comment('登録アカウント');
            $table->unsignedBigInteger('upd_account')->comment('更新アカウント');
            $table->boolean('del_flg')->default(0)->comment('削除フラグ');
            $table->datetime('created_at')->nullable()->comment('登録日時');  // 2038年問題対応 timestamp→datetime
            $table->datetime('updated_at')->nullable()->comment('更新日時');
            // インデックス情報
            $table->unique('login_user_id');
        });

        // テーブルコメント
        DB::statement("ALTER TABLE `system_admins` comment 'システム管理者'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('system_admins');
    }
}
