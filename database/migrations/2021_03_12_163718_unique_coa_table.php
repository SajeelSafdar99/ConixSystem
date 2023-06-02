<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UniqueCoaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
    {
        //
        Schema::table('coa_accounts',function (Blueprint $table){
             $table->unique('code');
        });

         Schema::table('coa_accounts_controls',function (Blueprint $table){
             $table->unique('code');
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
         Schema::table('coa_accounts',function (Blueprint $table){
             $table->dropUnique('code');
        });

         Schema::table('coa_accounts_controls',function (Blueprint $table){
             $table->dropUnique('code');
        });
    }
}
