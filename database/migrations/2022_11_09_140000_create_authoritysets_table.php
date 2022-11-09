<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuthoritySetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('authority_sets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('authority_id');
	    $table->unsignedBigInteger('function_id');
	    $table->unsignedTinyInteger('function_auth_flg');
	    $table->unsignedTinyInteger('create_auth_flg');
	    $table->unsignedTinyInteger('read_auth_flg');
	    $table->unsignedTinyInteger('update_auth_flg');
	    $table->unsignedTinyInteger('delete_auth_flg');
	    $table->unsignedTinyInteger('request_auth_flg');
	    $table->unsignedTinyInteger('approval_auth_flg');
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
        Schema::dropIfExists('authority_sets');
    }
}
