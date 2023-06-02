<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserstampsCreatedUpdatedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tables=['admin_company_profiles','bookingsubs','employment_in_out','event_bookingaddonsubs','event_bookingmenusubs','event_bookingsubs', 'event_menus_subs','finance_invoice_subs','mem_professionaffiliations', 'mem_profession_subs','mem_visits','permissions','roles'];
        foreach($tables as $t)
  {
         Schema::table($t, function (Blueprint $table) {

            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();

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
        $tables=['admin_company_profiles','bookingsubs','employment_in_out','event_bookingaddonsubs','event_bookingmenusubs','event_bookingsubs', 'event_menus_subs','finance_invoice_subs','mem_professionaffiliations', 'mem_profession_subs','mem_visits','permissions','roles'];
        foreach($tables as $t)
  {
         Schema::table($t, function (Blueprint $table) {
            $table->dropColumn('created_by');
            $table->dropColumn('updated_by');
        });

  } 
}


}
