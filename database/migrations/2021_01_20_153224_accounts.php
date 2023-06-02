<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Accounts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('accounts',function(Blueprint $t){
            $t->increments('id');
            $t->integer('code')->unique();
            $t->string('name');
            $t->longText('desc')->nullable();
            $t->boolean('status')->default(1);
            $t->timestamps();
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
        Schema::drop('accounts');
    }
}
