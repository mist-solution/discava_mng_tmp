<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanFunctionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plan_functions', function (Blueprint $table) {
            //$table->comment('プラン機能');  // Laravel 9.14 以降

            $table->id()->comment('ID');
            $table->unsignedBigInteger('plan_id')->comment('プランID');
            $table->unsignedBigInteger('function_id')->comment('機能ID');
            // レコード更新情報
            $table->unsignedBigInteger('add_account')->comment('登録アカウント');
            $table->unsignedBigInteger('upd_account')->comment('更新アカウント');
            $table->boolean('del_flg')->default(0)->comment('削除フラグ');
            $table->datetime('created_at')->nullable()->comment('登録日時');  // 2038年問題対応 timestamp→datetime
            $table->datetime('updated_at')->nullable()->comment('更新日時');
            // インデックス情報
            $table->unique(['plan_id','function_id']);
            // 外部キー情報
            $table->foreign('plan_id')->references('id')->on('plans');
            $table->foreign('function_id')->references('id')->on('functions');
        });

        // テーブルコメント
        DB::statement("ALTER TABLE `plan_functions` comment 'プラン機能'");
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
