<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFnbDiscountCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fnb_discount_cards', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->boolean('type')->nullable();
            $table->string('name')->nullable();
            $table->string('customer_id')->nullable();
            $table->string('card_number')->nullable();
            $table->bigInteger('discount_amount')->nullable();
            $table->bigInteger('discount_percentage')->nullable();
            $table->date('card_issue_date')->nullable();
            $table->date('card_expiry_date')->nullable();
            $table->boolean('status')->nullable();
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
        Schema::dropIfExists('fnb_discount_cards');
    }
}
