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
            $table->string('shop_name', 255)->comment('店舗名');
            $table->unsignedBigInteger('plan_id')->comment('プランID');
            $table->string('postal_code', 8)->comment('郵便番号');
            $table->string('address', 512)->comment('所在地');
            $table->string('building_name', 512)->nullable()->comment('建物名');
            $table->string('tel', 20)->comment('電話番号');
            $table->string('fax', 20)->nullable()->comment('FAX番号');
            $table->string('webapi_token', 128)->comment('WebAPIトークン');
            // レコード更新情報
            $table->unsignedBigInteger('add_account')->comment('登録アカウント');
            $table->unsignedBigInteger('upd_account')->comment('更新アカウント');
            $table->boolean('del_flg')->default(0)->comment('削除フラグ');
            $table->datetime('created_at')->nullable()->comment('登録日時');  // 2038年問題対応 timestamp→datetime
            $table->datetime('updated_at')->nullable()->comment('更新日時');
            // インデックス情報
            $table->index('customer_id');
            $table->index('shop_name');
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
