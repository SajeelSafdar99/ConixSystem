<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateCoaAccountControlsCostCenterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
      public function up()
    {    
         Schema::table('coa_accounts_controls',function (Blueprint $table){
            $table->string('cost_center')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    { 
         Schema::table('coa_accounts_controls',function (Blueprint $table){
            $table->dropColumn('cost_center');
        });
    }
}
