<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plans', function (Blueprint $table) {
            //$table->comment('プラン');  // Laravel 9.14 以降

            $table->id()->comment('ID');
            $table->string('name', 128)->comment('プラン名');
            $table->string('description', 1024)->nullable()->comment('プラン説明');
            // レコード更新情報
            $table->unsignedBigInteger('add_account');
            $table->unsignedBigInteger('upd_account');
            $table->boolean('del_flg')->default(0);
            $table->timestamps();  //created_at, updated_at
        });

        // テーブルコメント
        DB::statement("ALTER TABLE `plans` comment 'プラン'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plans');
    }
}
