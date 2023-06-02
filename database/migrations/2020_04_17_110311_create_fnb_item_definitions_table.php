<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFnbItemDefinitionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fnb_item_definitions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('category')->nullable();
            $table->string('sub_category')->nullable();
            $table->string('manufacturer')->nullable();
            $table->string('item_code')->nullable();
            $table->string('item_details')->nullable();
            $table->bigInteger('opening_stock')->nullable();
            $table->bigInteger('purchase_price')->nullable();
            $table->bigInteger('sale_price')->nullable();
            $table->string('unit')->nullable();
            $table->string('pos_location')->nullable();
            $table->string('product_classification')->nullable();
            $table->string('remarks')->nullable();
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
        Schema::dropIfExists('fnb_item_definitions');
    }
}
