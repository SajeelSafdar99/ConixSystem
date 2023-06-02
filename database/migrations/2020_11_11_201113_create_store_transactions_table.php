<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoreTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store_transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
           $table->date('date')->nullable();
           $table->integer('in_or_out')->comment('1 for in & 0 for out');
           $table->string('item_code')->nullable();
           $table->bigInteger('qty')->nullable();
           $table->bigInteger('store_location')->nullable();
           $table->bigInteger('department')->nullable();
            $table->integer('type')->nullable();
          $table->tinyInteger('is_active')->default(0);

           $table->softDeletes();
            $table->timestamps();
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
        Schema::dropIfExists('store_transactions');
    }
}
