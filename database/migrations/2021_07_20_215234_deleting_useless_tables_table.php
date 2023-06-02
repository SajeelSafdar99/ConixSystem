<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeletingUselessTablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   public function up()
    {
        Schema::dropIfExists('bookingcalenders');
        Schema::dropIfExists('finance_account_details');
        Schema::dropIfExists('finance_expenses');
        Schema::dropIfExists('finance_expense_heads');
        Schema::dropIfExists('finance_expense_paid_fors');
        Schema::dropIfExists('finance_expenses_subs');
        Schema::dropIfExists('finance_invoices_modules_lists');
        Schema::dropIfExists('finance_level_ones');
        Schema::dropIfExists('finance_level_threes');
        Schema::dropIfExists('finance_level_twos');
        Schema::dropIfExists('finance_payment_receivables');
        Schema::dropIfExists('finance_reports');
        Schema::dropIfExists('mem_addresses');
        Schema::dropIfExists('mem_affiliations');
        Schema::dropIfExists('memberships_docs');
        Schema::dropIfExists('membership_documents');
        Schema::dropIfExists('member_subscriptions');
        Schema::dropIfExists('mem_maintenances');
        Schema::dropIfExists('mem_monthly_subscriptions');
        Schema::dropIfExists('mem_professionaffiliation');
        Schema::dropIfExists('mem_professions');
        Schema::dropIfExists('mem_spsubcriptions');
        Schema::dropIfExists('partydetails');
        Schema::dropIfExists('payment_receipts_invoices');
        Schema::dropIfExists('payment_receipts_subs');
        Schema::dropIfExists('room_check_ins');
        Schema::dropIfExists('room_check_outs');
        Schema::dropIfExists('room_invoices');
        Schema::dropIfExists('room_ledgers');
        Schema::dropIfExists('room_payment_receipts');
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
