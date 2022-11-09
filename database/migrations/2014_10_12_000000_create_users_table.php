<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
	    $table->unsignedBigInteger('customer_id');
	    $table->string('login_user_id', 256)->unique();
	    $table->string('mail', 256)->unique();
	    $table->string('name', 50);
	    $table->string('initial_password', 128);
	    $table->string('password', 128);
	    $table->unsignedBigInteger('login_fail_count');
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
