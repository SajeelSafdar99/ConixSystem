<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UniqueFnbItemDefinitionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
      public function up()
    {
        //
        Schema::table('fnb_item_definitions',function (Blueprint $table){
             $table->unique('item_code');
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
         Schema::table('fnb_item_definitions',function (Blueprint $table){
             $table->dropUnique('item_code');
        });

    }
}
