<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTransactionsFiveTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transactions',function (Blueprint $table){
           $table->dropColumn('table_name');
            $table->dropColumn('details');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transactions',function (Blueprint $table){
           $table->string('table_name')->nullable();
           $table->string('details')->nullable();
        });
    }
}
