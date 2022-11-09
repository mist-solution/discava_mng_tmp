<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanFunctionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plan_function', function (Blueprint $table) {
            //$table->comment('プラン機能');  // Laravel 9.14 以降

            $table->unsignedBigInteger('plan_id')->comment('プランID');
            $table->unsignedBigInteger('function_id')->comment('機能ID');
            // レコード更新情報
            $table->unsignedBigInteger('add_account');
            $table->unsignedBigInteger('upd_account');
            $table->boolean('del_flg')->default(0);
            $table->timestamps();  //created_at, updated_at
            // 外部キー情報
            $table->foreign('plan_id')->references('id')->on('plans');
            $table->foreign('function_id')->references('id')->on('functions');
        });

        // テーブルコメント
        DB::statement("ALTER TABLE `plan_function` comment 'プラン機能'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plan_function');
    }
}
