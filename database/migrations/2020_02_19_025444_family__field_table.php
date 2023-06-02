<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FamilyFieldTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tables=['room_bookings','room_payment_receipts'];
        foreach($tables as $t)
  {
         Schema::table($t, function (Blueprint $table) {
         $table->string('family')->nullable();
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
         $tables=['room_bookings','room_payment_receipts'];
        foreach($tables as $t)
  {
         Schema::table($t, function (Blueprint $table) {
         $table->dropColumn('family');
        });

  }
    }
}
