<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateFinanceLevelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('finance_account_heads', function (Blueprint $table) {
            $table->bigInteger('level_one')->nullable();
            $table->bigInteger('level_two')->nullable();
            $table->bigInteger('level_three')->nullable();
        });

        Schema::table('finance_account_types', function (Blueprint $table) {
            $table->bigInteger('level_one')->nullable();
            $table->bigInteger('level_two')->nullable();
            $table->bigInteger('level_three')->nullable();
            $table->bigInteger('level_four')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('finance_account_heads',function(Blueprint $table){
            $table->dropColumn('level_one');
            $table->dropColumn('level_two');
            $table->dropColumn('level_three');
        });

        Schema::table('finance_account_types',function(Blueprint $table){
            $table->dropColumn('level_one');
            $table->dropColumn('level_two');
            $table->dropColumn('level_three');
            $table->dropColumn('level_four');
        });
    }
}
