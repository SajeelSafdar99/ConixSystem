<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFinanceGeneralVouchersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('finance_general_vouchers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('invoice_no')->unique()->nullable();
             $table->date('invoice_date')->nullable();
              $table->string('voucher_type')->nullable();
              $table->boolean('invoice_type')->nullable();
              $table->string('name')->nullable();
                  $table->string('address')->nullable();
                  $table->string('cnic')->nullable();
                   $table->string('contact')->nullable(); 
                    $table->string('email')->nullable(); 
                   $table->string('ledger_amount')->nullable();
            $table->bigInteger('person_id')->unsigned()->nullable();
            $table->bigInteger('customer_id')->unsigned()->nullable();
            $table->bigInteger('mem_number')->unsigned()->nullable();
            $table->string('debit_amount')->nullable();
                  $table->string('debit_details')->nullable();
                   $table->string('credit_amount')->nullable(); 
 $table->string('credit_details')->nullable();
$table->date('account_date')->nullable();
$table->boolean('status')->nullable();
$table->string('account')->nullable();
$table->string('acc_details')->nullable(); 
$table->string('remarks')->nullable();
$table->text('documents')->nullable();
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
        Schema::dropIfExists('finance_general_vouchers');
    }
}
