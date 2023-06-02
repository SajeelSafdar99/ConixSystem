<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateMembershipsCoaCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
    {    
         Schema::table('memberships',function (Blueprint $table){
            $table->string('coa_category_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    { 
         Schema::table('memberships',function (Blueprint $table){
            $table->dropColumn('coa_category_id');
        });
    }
}
