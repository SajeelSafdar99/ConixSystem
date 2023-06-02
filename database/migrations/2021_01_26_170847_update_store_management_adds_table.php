<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateStoreManagementAddsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
    {
        Schema::table('store_purchases',function(Blueprint $table){
             $table->bigInteger('additional_charges')->nullable();
        });

        Schema::table('store_sales',function(Blueprint $table){
             $table->bigInteger('additional_charges')->nullable();
        });

        Schema::table('store_issue_notes',function(Blueprint $table){
             $table->bigInteger('additional_charges')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('store_purchases',function(Blueprint $table){
            $table->dropColumn('additional_charges');
        });

        Schema::table('store_sales',function(Blueprint $table){
            $table->dropColumn('additional_charges');
        });

        Schema::table('store_issue_notes',function(Blueprint $table){
            $table->dropColumn('additional_charges');
        });
    }
}
