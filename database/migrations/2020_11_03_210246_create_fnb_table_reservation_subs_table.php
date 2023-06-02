<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFnbTableReservationSubsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fnb_table_reservation_subs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('sales_id')->nullable();
             $table->float('qty')->nullable();
              $table->string('item_code')->nullable();
            $table->string('item_details')->nullable();
            $table->bigInteger('sale_price')->nullable();
             $table->float('total')->nullable();
             $table->string('instruction')->nullable();
              $table->bigInteger('sub_total_price')->nullable();
               $table->Integer('kot_no')->nullable();
           $table->float('item_discount')->nullable();
        $table->string('status')->nullable();
          $table->boolean('saved')->nullable();
        $table->string('remark')->nullable();
        $table->string('aftercancel')->nullable();
        $table->bigInteger('subcategory')->nullable();
        $table->date('date')->nullable();

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
        Schema::dropIfExists('fnb_table_reservation_subs');
    }
}
