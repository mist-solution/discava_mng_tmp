<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonalAccessTokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personal_access_tokens', function (Blueprint $table) {
            $table->id()->comment('ID');
            $table->morphs('tokenable');
            $table->string('name')->comment('名称');
            $table->string('token', 64)->comment('トークン');
            $table->text('abilities')->nullable()->comment('アビリティー');
            $table->datetime('last_used_at')->nullable()->comment('最終利用日時');  // 2038年問題対応 timestamp→datetime
            $table->datetime('created_at')->nullable()->comment('登録日時');
            $table->datetime('updated_at')->nullable()->comment('更新日時');
            // インデックス情報
            $table->unique('token');
        });

        // テーブルコメント
        DB::statement("ALTER TABLE `personal_access_tokens` comment 'パーソナルアクセストークン'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('personal_access_tokens');
    }
}
