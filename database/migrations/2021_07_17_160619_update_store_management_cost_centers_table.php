<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateStoreManagementCostCentersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('store_issue_notes_subs',function (Blueprint $table){
            $table->string('cost_center')->nullable();
        });

        Schema::table('store_sales_subs',function (Blueprint $table){
            $table->string('cost_center')->nullable();
        });

        Schema::table('store_purchases_subs',function (Blueprint $table){
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

       Schema::table('store_issue_notes_subs',function (Blueprint $table){
            $table->dropColumn('cost_center');
        });
        
         Schema::table('store_sales_subs',function (Blueprint $table){
            $table->dropColumn('cost_center');
        });
        
         Schema::table('store_purchases_subs',function (Blueprint $table){
            $table->dropColumn('cost_center');
        });
        
    }
}
