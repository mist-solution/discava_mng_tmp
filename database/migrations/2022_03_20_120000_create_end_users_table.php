<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEndUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('end_users', function (Blueprint $table) {
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->primary(['customer_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('end_users');
    }
}
