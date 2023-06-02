<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateStoreTransactionsIssuePriceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('store_transactions',function (Blueprint $table){
            $table->decimal('issue_price', 8, 1)->nullable();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    { 

       Schema::table('store_transactions',function (Blueprint $table){
            $table->dropColumn('issue_price');
        });
        
    }
}
