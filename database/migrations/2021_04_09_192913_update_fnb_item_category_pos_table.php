<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateFnbItemCategoryPosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   public function up()
    {
        Schema::table('fnb_item_categories',function (Blueprint $table){
            $table->dropColumn('account');
            $table->bigInteger('pos_location')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    { 
        Schema::table('fnb_item_categories',function (Blueprint $table){
            $table->string('account')->nullable();
            $table->dropColumn('pos_location');
        });
    }
}
