<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateFinanceBooksTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
    {
        //
        Schema::table('finance_books',function (Blueprint $table){
            $table->boolean('debit_or_credit');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('finance_books',function (Blueprint $table){
            $table->dropColumn('debit_or_credit');
        });

       
    }
}
