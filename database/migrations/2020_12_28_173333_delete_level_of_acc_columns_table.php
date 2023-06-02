<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeleteLevelOfAccColumnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('finance_level_threes',function(Blueprint $table){
             $table->dropColumn('level_one');
        });

        Schema::table('finance_account_heads',function(Blueprint $table){
             $table->dropColumn('level_one');
             $table->dropColumn('level_two');
        });

        Schema::table('finance_account_types',function(Blueprint $table){
             $table->dropColumn('level_one');
             $table->dropColumn('level_two');
             $table->dropColumn('level_three');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('finance_level_threes',function(Blueprint $table){
             $table->bigInteger('level_one')->nullable();
        });

        Schema::table('finance_account_heads',function(Blueprint $table){
             $table->bigInteger('level_one')->nullable();
             $table->bigInteger('level_two')->nullable();
        });

        Schema::table('finance_account_types',function(Blueprint $table){
             $table->bigInteger('level_one')->nullable();
             $table->bigInteger('level_two')->nullable();
             $table->bigInteger('level_three')->nullable();
        });
    }
}
