<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateAdminCompanyProfileCostcenterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
      public function up()
    {
        Schema::table('admin_company_profiles',function (Blueprint $table){
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

       Schema::table('admin_company_profiles',function (Blueprint $table){
            $table->dropColumn('cost_center');
        });
        
        
    }
}
