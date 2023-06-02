<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStorePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
          Schema::create('store_purchases', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('invoice_date')->nullable();
            $table->bigInteger('gross')->nullable();
            $table->bigInteger('surcharge')->nullable();
            $table->bigInteger('grand_total')->nullable();
            $table->bigInteger('customer_id')->nullable();
            $table->string('remarks')->nullable();
            $table->string('amount_in_words')->nullable();
            $table->bigInteger('account')->nullable();
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
        Schema::dropIfExists('store_purchases');
    }
}
