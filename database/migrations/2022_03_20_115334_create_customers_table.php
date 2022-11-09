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
            $table->string('company_name', 256);
            $table->string('business_content', 256)->nullable();
            $table->string('postal_code', 8);
	    $table->string('address', 512);
	    $table->string('building_name', 1024)->nullable();
            $table->string('tel', 20);
            $table->string('fax', 20)->nullable();
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
