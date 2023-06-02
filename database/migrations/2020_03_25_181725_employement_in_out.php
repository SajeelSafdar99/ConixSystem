<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EmployementInOut extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employment_in_out', function (Blueprint $table) {
            //
            $table->increments('id');
            $table->integer('employee_id');
            $table->boolean('in_out')->comment('0 for in 1 for out');
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
        Schema::drop('employment_in_out');
    }
}
