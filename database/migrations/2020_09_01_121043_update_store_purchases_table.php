<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateStorePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('store_purchases', function (Blueprint $table) {
            $table->bigInteger('store_location')->nullable();
            $table->dropColumn('account');
            $table->dropColumn('surcharge');
            $table->bigInteger('discount')->nullable();
            $table->bigInteger('tax')->nullable();
        });

        Schema::table('store_purchases_subs', function (Blueprint $table) {
            $table->dropColumn('sale_price');
            $table->bigInteger('purchase_price')->nullable();
            $table->string('instructions')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('store_purchases',function(Blueprint $table){
            $table->dropColumn('store_location');
            $table->bigInteger('account')->nullable();
            $table->bigInteger('surcharge')->nullable();
            $table->dropColumn('discount');
            $table->dropColumn('tax');
        });

         Schema::table('store_purchases_subs',function(Blueprint $table){
            $table->bigInteger('sale_price')->nullable();
            $table->dropColumn('purchase_price');
            $table->dropColumn('instructions');
        });
    }
}
