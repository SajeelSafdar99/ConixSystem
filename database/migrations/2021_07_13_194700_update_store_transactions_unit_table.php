<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateStoreTransactionsUnitTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
    {
        Schema::table('store_transactions',function (Blueprint $table){
             $table->string('unit')->nullable();
           
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    { 

       Schema::table('store_transactions',function (Blueprint $table){
             $table->dropColumn('unit');
        });
        
    }
}
