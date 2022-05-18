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
            $table->id();
            $table->char('code', 16)->unique();
            $table->string('company_name', 128);
            $table->text('business_content', 256)->nullable();
            $table->string('postal_code', 9);
            $table->string('address', 256);
            $table->string('tel', 16);
            $table->string('fax', 16)->nullable();
            $table->string('mail', 256)->nullable();
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
        Schema::dropIfExists('customers');
    }
}
