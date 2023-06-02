<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFnbCakeBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fnb_cake_bookings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('booking_no')->nullable();
            $table->date('booking_date')->nullable();
            $table->string('order_taker')->nullable();
            $table->boolean('type')->nullable();
            $table->string('name')->nullable();
            $table->bigInteger('customer_id')->nullable();
            $table->bigInteger('family')->nullable();

            $table->bigInteger('cake_type')->nullable();
            $table->string('flavor')->nullable();
            $table->string('topping')->nullable();
            $table->string('filling')->nullable();
            $table->string('icing')->nullable();
            $table->string('color')->nullable();
            $table->float('weight', 8, 2)->nullable();
            $table->string('instructions')->nullable();
            $table->string('attachment')->nullable();
            $table->string('special_display')->nullable();

            $table->date('delivery_date')->nullable();
            $table->time('pickup_time')->nullable();

            $table->string('receiver')->nullable();
            $table->string('delivery_address')->nullable();
            $table->string('note')->nullable();
            $table->bigInteger('total_amount')->nullable();
            $table->float('discount', 8,1)->nullable();
            $table->float('tax', 8,1)->nullable();
            $table->bigInteger('grand_total')->nullable();

            $table->bigInteger('payment_method')->nullable();
            $table->boolean('status')->nullable();
            
            $table->text('document')->nullable();

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
        Schema::dropIfExists('fnb_cake_bookings');
    }
}
