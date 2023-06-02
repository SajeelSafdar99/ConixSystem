<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateFnbSaleEntDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
      public function up()
    {
        //
        Schema::table('fnb_sales',function (Blueprint $table){
             $table->bigInteger('ent_detail')->nullable();
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
        Schema::table('fnb_sales',function (Blueprint $table){
            $table->dropColumn('ent_detail');
        });
    }
}
