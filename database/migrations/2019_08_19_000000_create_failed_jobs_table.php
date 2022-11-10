<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFailedJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('failed_jobs', function (Blueprint $table) {
            $table->id()->comment('ID');
            $table->string('uuid')->comment('UUID');
            $table->text('connection')->comment('接続情報');
            $table->text('queue')->comment('キュー');
            $table->longText('payload')->comment('ペイロード');
            $table->longText('exception')->comment('例外情報');
            $table->datetime('failed_at')->useCurrent()->comment('失敗日時');  // 2038年問題対応 timestamp→datetime
            // インデックス情報
            $table->unique('uuid');
        });

        // テーブルコメント
        DB::statement("ALTER TABLE `failed_jobs` comment 'ジョブ失敗履歴'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('failed_jobs');
    }
}
