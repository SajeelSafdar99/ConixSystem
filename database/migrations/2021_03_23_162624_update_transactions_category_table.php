<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTransactionsCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {    
         Schema::table('transactions',function (Blueprint $table){
            $table->integer('trans_moc_category')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    { 
         Schema::table('transactions',function (Blueprint $table){
            $table->dropColumn('trans_moc_category');
        });
    }
}
