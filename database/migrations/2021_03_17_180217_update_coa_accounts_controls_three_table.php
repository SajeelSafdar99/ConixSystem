<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateCoaAccountsControlsThreeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
    {
         
         Schema::table('coa_accounts_controls',function (Blueprint $table){
             $table->integer('def')->nullable();
             $table->boolean('show')->nullable();
              $table->text('remarks')->nullable();
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
             $table->dropColumn('def');
             $table->dropColumn('def');
             $table->dropColumn('remarks');
        });
    }
}
