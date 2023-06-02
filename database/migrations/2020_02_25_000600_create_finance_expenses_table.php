<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFinanceExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('finance_expenses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('ledger_person_id')->unsigned()->nullable();
            $table->foreign('ledger_person_id')->references('id')->on('finance_ledger_people')->onDelete('set null')->onUpdate('cascade');

            $table->bigInteger('person_id')->unsigned()->nullable();

            $table->string('invoice_no')->unique()->nullable();
             $table->string('invoice_date')->nullable();
              $table->string('person_name')->nullable();
                  $table->string('person_address')->nullable();
                  $table->string('person_cnic')->nullable();
                   $table->string('person_contact')->nullable(); 
                    $table->string('person_email')->nullable(); 
                   $table->string('ledger_amount')->nullable();
 
              $table->string('expense_paid_for')->nullable();    
               $table->string('expense_details')->nullable();

            $table->string('payment_method')->nullable();
             $table->string('payment_mode_details')->nullable();

               $table->string('total_amount')->nullable();
       
              $table->string('surcharge')->nullable();
       
              $table->string('total')->nullable();
              
              $table->string('amount_in_words')->nullable();
            $table->text('documents')->nullable();
            $table->string('remarks')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('finance_expenses');
    }
}
