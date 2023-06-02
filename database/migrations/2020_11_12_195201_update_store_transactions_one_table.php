<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateStoreTransactionsOneTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('store_transactions',function(Blueprint $table){
            $table->bigInteger('type_id')->nullable();
            $table->bigInteger('sub_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('store_transactions',function(Blueprint $table){
            $table->dropColumn('type_id');
            $table->dropColumn('sub_id');
        });
    }
}
