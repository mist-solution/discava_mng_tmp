<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shops', function (Blueprint $table) {
            //$table->comment('店舗');  // Laravel 9.14 以降

            $table->id()->comment('ID');
            $table->unsignedBigInteger('customer_id')->comment('顧客ID');
            $table->string('shop_name', 256)->comment('店舗名');
            $table->unsignedBigInteger('plan_id')->comment('プランID');
            // レコード更新情報
            $table->unsignedBigInteger('add_account');
            $table->unsignedBigInteger('upd_account');
            $table->boolean('del_flg')->default(0);
            $table->timestamps();  //created_at, updated_at
            // 外部キー情報
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->foreign('plan_id')->references('id')->on('plans');
        });

        // テーブルコメント
        DB::statement("ALTER TABLE `shops` comment '店舗'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shops');
    }
}
