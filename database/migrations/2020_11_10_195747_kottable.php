<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Kottable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('sqlite')->create('kotrec', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('order');
            $table->integer('category');
            $table->integer('kot_id');
            $table->integer('user');
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
        //
        Schema::connection('sqlite')->dropIfExists('kotrec');
    }
}
