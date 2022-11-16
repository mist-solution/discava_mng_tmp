<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            //$table->comment('顧客');  // Laravel 9.14 以降

            $table->id()->comment('ID');
            $table->string('company_name', 256)->comment('会社名');
            $table->string('business_content', 256)->nullable()->comment('事業内容');
            $table->string('postal_code', 8)->comment('郵便番号');
            $table->string('address', 512)->comment('所在地');
            $table->string('building_name', 1024)->nullable()->comment('建物名');
            $table->string('tel', 20)->comment('電話番号');
            $table->string('fax', 20)->nullable()->comment('FAX番号');
            $table->string('mail', 256)->nullable()->comment('メールアドレス');
            // レコード更新情報
            $table->unsignedBigInteger('add_account')->comment('登録アカウント');
            $table->unsignedBigInteger('upd_account')->comment('更新アカウント');
            $table->boolean('del_flg')->default(0)->comment('削除フラグ');
            $table->datetime('created_at')->nullable()->comment('登録日時');  // 2038年問題対応 timestamp→datetime
            $table->datetime('updated_at')->nullable()->comment('更新日時');
            // インデックス情報
            $table->index('company_name');
        });

        // テーブルコメント
        DB::statement("ALTER TABLE `customers` comment '顧客'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers');
    }
}
