<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFnbTableReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fnb_table_reservations', function (Blueprint $table) {
             $table->bigIncrements('id');
            $table->string('reservation_no')->unique()->nullable();
             $table->date('reservation_date')->nullable();
              $table->string('nature_of_function')->nullable();
                $table->string('from_time')->nullable();
                $table->string('to_time')->nullable();
             $table->string('theme')->nullable();
             $table->string('arrangement_details')->nullable();

        $table->string('invoice_no')->unique()->nullable();
            $table->date('date')->nullable();
            $table->string('time')->nullable();
            $table->string('restaurant_location')->nullable();
            $table->string('table_definition')->nullable();
            $table->string('waiter_definition')->nullable();
            $table->string('order_type')->nullable();

            $table->boolean('type')->nullable();
            $table->string('name')->nullable();
            $table->string('customer_id')->nullable();
             $table->string('family')->nullable();
          /*  $table->string('contact')->nullable();*/
          /*    $table->bigInteger('ledger_amount')->nullable();*/

            $table->bigInteger('covers')->nullable();
           
            $table->string('discount_card_no')->nullable();
            $table->float('disc_pc')->nullable();
            $table->float('disc')->nullable();

            $table->bigInteger('gross')->nullable();
            $table->float('discount')->nullable();
            $table->float('sub_total')->nullable();
            $table->bigInteger('tax')->nullable();
            $table->bigInteger('service_charges')->nullable();
            $table->bigInteger('service_charges_pct')->nullable();
            $table->bigInteger('grand_total')->nullable();

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
        Schema::dropIfExists('fnb_table_reservations');
    }
}
