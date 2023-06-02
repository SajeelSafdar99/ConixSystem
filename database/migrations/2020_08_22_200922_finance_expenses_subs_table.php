<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FinanceExpensesSubsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('finance_expenses_subs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('expense_id')->nullable();
            $table->bigInteger('person_id')->nullable();

            $table->bigInteger('expense_head')->nullable();
            $table->bigInteger('expense_payable')->nullable();
            $table->string('expense_details')->nullable();
            $table->bigInteger('charges')->nullable();

            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('finance_expenses_subs');
    }
}
