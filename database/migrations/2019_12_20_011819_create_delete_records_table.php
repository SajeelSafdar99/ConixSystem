<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;


class CreateDeleteRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tables=['customers','room_types','room_categories','room_charges_types','rooms','room_bookings','room_payment_receipts','room_category_charges','finance_payment_receivables', 'users'];
        foreach($tables as $t)
  {
         Schema::table($t, function (Blueprint $table) {
         $table->softDeletes();
        });

  } }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $tables=['customers','room_types','room_categories','room_charges_types','rooms','room_bookings','room_payment_receipts','room_category_charges','finance_payment_receivables', 'users'];
        foreach($tables as $t)
  {
         Schema::table($t, function (Blueprint $table) {
          $table->dropSoftDeletes();
        });

  } }
}
