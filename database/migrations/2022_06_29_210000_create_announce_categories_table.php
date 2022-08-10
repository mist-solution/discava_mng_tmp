<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnnounceCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('announce_categories', function (Blueprint $table) {
            $table->id();
            $table->string('code', 8);
            // contract が曖昧なため
            $table->unsignedInteger('contract_id')->nullable();
            $table->string('category',128);
            $table->text('description')->nullable();
            $table->text('icon')->nullable();
            $table->boolean('del_flg')->default(0);
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
        Schema::dropIfExists('announce_categories');
    }
}
