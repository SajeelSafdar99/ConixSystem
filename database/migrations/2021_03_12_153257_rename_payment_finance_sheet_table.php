<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenamePaymentFinanceSheetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename('finance_expense_news', 'payment_finance_sheets');
        Schema::rename('finance_expense_new_subs', 'payment_finance_sheet_subs');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::rename('payment_finance_sheets', 'finance_expense_news');
        Schema::rename('payment_finance_sheet_subs', 'finance_expense_new_subs');
    }
}
