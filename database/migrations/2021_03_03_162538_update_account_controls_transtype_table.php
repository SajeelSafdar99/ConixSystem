<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateAccountControlsTranstypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
      public function up()
    {
        //
        Schema::table('accounts_controls',function (Blueprint $table){
             $table->bigInteger('trans_type')->nullable();
        });

        Schema::table('accounts',function (Blueprint $table){
             $table->dropColumn('trans_type');
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
        Schema::table('accounts_controls',function (Blueprint $table){
            $table->dropColumn('trans_type');
        });

        Schema::table('accounts',function (Blueprint $table){
             $table->bigInteger('trans_type')->nullable();
        });
    }
}
