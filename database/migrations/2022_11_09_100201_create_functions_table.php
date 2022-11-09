<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFunctionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('functions', function (Blueprint $table) {
            //$table->comment('機能');  // Laravel 9.14 以降

            $table->id()->comment('ID');
            $table->string('name', 128)->comment('機能名');
            $table->string('description', 1024)->nullable()->comment('機能説明');
            // レコード更新情報
            $table->unsignedBigInteger('add_account');
            $table->unsignedBigInteger('upd_account');
            $table->boolean('del_flg')->default(0);
            $table->timestamps();  //created_at, updated_at
        });

        // テーブルコメント
        DB::statement("ALTER TABLE `functions` comment '機能'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('functions');
    }
}
