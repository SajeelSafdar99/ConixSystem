<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFinanceExpenseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('finance_expense', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->bigInteger('expense_no')->nullable();
            $table->date('expense_date')->nullable();
            $table->bigInteger('supplier_id')->nullable();
            $table->text('unit')->nullable();
            $table->text('code')->nullable();
            $table->string('name')->nullable();
            $table->bigInteger('amount')->nullable();
            $table->text('description')->nullable();
            $table->string('status')->nullable();
            $table->text('remarks')->nullable();
            $table->text('comments')->nullable();

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
        Schema::dropIfExists('finance_expense');
    }
}
