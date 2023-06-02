<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFinanceExpenseNewSubsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
    {
        Schema::create('finance_expense_new_subs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('expense_id')->nullable();
            $table->bigInteger('unit')->nullable();
            $table->text('code')->nullable();
            $table->string('name')->nullable();
            $table->text('payment_method')->nullable();
            $table->bigInteger('amount')->nullable();
             $table->text('description')->nullable();
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
        Schema::dropIfExists('finance_expense_new_subs');
    }
}
