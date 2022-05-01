<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnnounceCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('announce_category', function (Blueprint $table) {
            $table->id();
            $table->string('code', 8);
            $table->unsignedInteger('contract_id');
            $table->string('category',128);
            $table->text('description');
            $table->text('icon');
            $table->boolean('del_flg');
            $table->bigInteger('add_account');
            $table->bigInteger('upd_account');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('announce_category');
    }
}
