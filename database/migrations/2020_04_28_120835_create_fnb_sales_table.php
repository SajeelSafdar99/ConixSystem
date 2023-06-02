<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFnbSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fnb_sales', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('invoice_no')->unique()->nullable();
            $table->date('date')->nullable();
            $table->time('time')->nullable();
            $table->string('restaurant_location')->nullable();
            $table->string('currency')->nullable();
            $table->string('table_definition')->nullable();
            $table->string('waiter_definition')->nullable();
            $table->string('order_type')->nullable();
            $table->string('payment_mode')->nullable();
            $table->bigInteger('gross')->nullable();
            $table->bigInteger('discount')->nullable();
            $table->bigInteger('sub_total')->nullable();
            $table->bigInteger('tax')->nullable();
            $table->bigInteger('service_charges')->nullable();
            $table->bigInteger('grand_total')->nullable();
            $table->boolean('type')->nullable();
            $table->string('name')->nullable();
            $table->string('customer_id')->nullable();
            $table->string('contact')->nullable();
            $table->bigInteger('covers')->nullable();
            $table->string('qot_no')->nullable();
            $table->bigInteger('disc')->nullable();
            $table->string('category')->nullable();
            $table->string('sub_category')->nullable();
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
        Schema::dropIfExists('fnb_sales');
    }
}
