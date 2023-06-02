<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FnbSalesSubsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fnb_sales_subs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('sales_id')->nullable();
            $table->bigInteger('qty')->nullable();
            $table->string('item_code')->nullable();
            $table->string('item_details')->nullable();
            $table->bigInteger('sale_price')->nullable();
            $table->bigInteger('total')->nullable();
            $table->string('instruction')->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fnb_sales_subs');
    }
}
