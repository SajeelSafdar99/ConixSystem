<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateFinanceLevelsTwoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::table('finance_account_types', function (Blueprint $table) {
            $table->dropColumn('level_four');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         Schema::table('finance_account_types',function(Blueprint $table){
            $table->bigInteger('level_four')->nullable();
        });
    }
}
