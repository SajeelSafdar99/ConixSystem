<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameFnbSubcatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fnb_item_sub_categories',function (Blueprint $table){
            $table->renameColumn('pos_location','printer');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fnb_item_sub_categories',function (Blueprint $table){
            $table->renameColumn('printer','pos_location');
        });

    }
}
