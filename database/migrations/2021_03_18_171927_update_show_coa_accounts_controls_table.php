<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateShowCoaAccountsControlsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
    {
         
         Schema::table('coa_accounts_controls',function (Blueprint $table){
            $table->boolean('show')->nullable(false)->default(0)->change();
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
             $table->boolean('show')->nullable(true)->default(null)->change();
        });
    }
}
