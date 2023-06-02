<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserstampsDeletedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
     {
        $tables=['customers','event_bookings','event_charges_types', 'event_menus','event_menu_add_ons','event_rate_categories','event_types','event_venues','finance_account_heads','finance_account_types','finance_expenses','finance_expense_paid_fors', 'finance_general_vouchers','finance_invoices','finance_invoice_charges_types','finance_ledger_people','finance_payment_methods','finance_payment_receipts', 'finance_payment_receivables','finance_voucher_types','hr_departments', 'hr_employments','media','memberships','member_subscriptions','mem_cars','mem_categories','mem_classifications', 'mem_club_facilities','mem_families','mem_occupations','mem_relations','mem_statuses','permission_categories', 'rooms','room_bookings','room_categories', 'room_category_charges','room_charges_types','room_payment_receipts','room_types','sports_subscriptions','users'];
        foreach($tables as $t)
  {
         Schema::table($t, function (Blueprint $table) {

            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();

        });

  } 
}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
     {
        $tables=['customers','event_bookings','event_charges_types', 'event_menus','event_menu_add_ons','event_rate_categories','event_types','event_venues','finance_account_heads','finance_account_types','finance_expenses','finance_expense_paid_fors', 'finance_general_vouchers','finance_invoices','finance_invoice_charges_types','finance_ledger_people','finance_payment_methods','finance_payment_receipts', 'finance_payment_receivables','finance_voucher_types','hr_departments', 'hr_employments','media','memberships','member_subscriptions','mem_cars','mem_categories','mem_classifications', 'mem_club_facilities','mem_families','mem_occupations','mem_relations','mem_statuses','permission_categories', 'rooms','room_bookings','room_categories', 'room_category_charges','room_charges_types','room_payment_receipts','room_types','sports_subscriptions','users'];
        foreach($tables as $t)
  {
         Schema::table($t, function (Blueprint $table) {
            $table->dropColumn('created_by');
            $table->dropColumn('updated_by');
            $table->dropColumn('deleted_by');
            
        });

  } 
}

}
