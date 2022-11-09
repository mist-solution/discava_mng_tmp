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
            $table->id();
            $table->unsignedBigInteger('authority_id');
            $table->unsignedBigInteger('function_id');
            $table->unsignedTinyInteger('function_auth_flg');
            $table->unsignedTinyInteger('create_auth_flg');
            $table->unsignedTinyInteger('read_auth_flg');
            $table->unsignedTinyInteger('update_auth_flg');
            $table->unsignedTinyInteger('delete_auth_flg');
            $table->unsignedTinyInteger('request_auth_flg');
            $table->unsignedTinyInteger('approval_auth_flg');
            // レコード更新情報
            $table->unsignedBigInteger('add_account');
            $table->unsignedBigInteger('upd_account');
            $table->boolean('del_flg')->default(0);
            $table->timestamps();  //created_at, updated_at
            // インデックス情報
            $table->unique(['authority_id', 'function_id']);
            // 外部キー情報
            $table->foreign('function_id')->references('id')->on('functions');
        });
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
