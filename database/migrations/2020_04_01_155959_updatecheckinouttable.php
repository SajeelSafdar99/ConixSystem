<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Updatecheckinouttable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('employment_in_out', function (Blueprint $table) {
            //
            $table->string('workingHours')->nullable();
           
           

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('employment_in_out', function (Blueprint $table) {
            //
            $table->drop('workingHours');
           
           

        });
    }
}
