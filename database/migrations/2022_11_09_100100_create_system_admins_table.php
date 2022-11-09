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
            $table->comment('システム管理者');
            
            $table->id()->comment('ID');
            $table->string('login_user_id', 256)->comment('ログインユーザID');
            $table->string('mail', 256)->comment('メールアドレス');
            $table->string('name', 50)->comment('システム管理者名');
            $table->string('initial_password', 128)->comment('初期パスワード');
            $table->string('password', 128)->comment('パスワード');
            // レコード更新情報
            $table->unsignedBigInteger('add_account');
            $table->unsignedBigInteger('upd_account');
            $table->boolean('del_flg')->default(0);
            $table->timestamps();  //created_at, updated_at
            // インデックス情報
            $table->unique('login_user_id');
        });
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
