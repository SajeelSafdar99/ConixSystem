<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateFinanceExpenseNewTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
    {
        //
        Schema::table('finance_expense_news',function (Blueprint $table){
            $table->text('comments')->nullable();
        });

         Schema::table('finance_expense_new_subs',function (Blueprint $table){
             $table->text('unit')->change();
             $table->string('status')->nullable();
             $table->text('remarks')->nullable();
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
        Schema::table('finance_expense_news',function (Blueprint $table){
            $table->dropColumn('comments');
        });

        Schema::table('finance_expense_new_subs',function (Blueprint $table){
             $table->bigInteger('unit')->change();
             $table->dropColumn('status');
             $table->dropColumn('remarks');
        });
    }
}
