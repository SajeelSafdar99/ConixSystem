<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateStoreAllThreeModulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
    {
        Schema::table('store_purchases_subs',function(Blueprint $table){
            $table->string('remark')->nullable();
             $table->string('aftercancel')->nullable();
             $table->string('status')->nullable();
        });

        Schema::table('store_sales_subs',function(Blueprint $table){
            $table->string('remark')->nullable();
             $table->string('aftercancel')->nullable();
             $table->string('status')->nullable();
        });

        Schema::table('store_issue_notes_subs',function(Blueprint $table){
            $table->string('remark')->nullable();
             $table->string('aftercancel')->nullable();
             $table->string('status')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('store_purchases_subs',function(Blueprint $table){
            $table->dropColumn('remark');
            $table->dropColumn('aftercancel');
            $table->dropColumn('status');
        });

         Schema::table('store_sales_subs',function(Blueprint $table){
            $table->dropColumn('remark');
            $table->dropColumn('aftercancel');
            $table->dropColumn('status');
        });

          Schema::table('store_issue_notes_subs',function(Blueprint $table){
            $table->dropColumn('remark');
            $table->dropColumn('aftercancel');
            $table->dropColumn('status');
        });
    }
}
