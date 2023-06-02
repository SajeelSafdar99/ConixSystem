<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateStoreIssueNotePriceamtTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
    {
        Schema::table('store_issue_notes_subs',function (Blueprint $table){
             $table->bigInteger('old_purchase_price')->nullable();
           
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
             $table->dropColumn('old_purchase_price');
        });
        
    }
}
