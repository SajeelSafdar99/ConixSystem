<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateStoreModulesUnitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
      public function up()
    {
        Schema::table('store_purchases_subs',function(Blueprint $table){
            $table->integer('unit')->nullable();
        });

        Schema::table('store_sales_subs',function(Blueprint $table){
           $table->integer('unit')->nullable();
        });

        Schema::table('store_issue_notes_subs',function(Blueprint $table){
            $table->integer('unit')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('store_purchases_subs',function(Blueprint $table){
            $table->dropColumn('unit');
        });

         Schema::table('store_sales_subs',function(Blueprint $table){
            $table->dropColumn('unit');
        });

          Schema::table('store_issue_notes_subs',function(Blueprint $table){
            $table->dropColumn('unit');
        });
    }
}
