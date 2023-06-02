<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameFinanceInvoicesModulesListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   public function up()
    {
        /*if (!Schema::hasTable('trans_types')) {
    Schema::rename('finance_invoices_modules_lists', 'trans_types');
            }*/

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       /* if (Schema::hasTable('trans_types')) {
    Schema::rename('trans_types', 'finance_invoices_modules_lists');
        }*/
    }
}
