<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateFnbSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fnb_sales',function(Blueprint $table){
            $table->dropColumn('payment_mode');
            $table->string('account_head')->nullable();
            $table->string('account_type')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fnb_sales',function(Blueprint $table){
            $table->string('payment_mode')->nullable();
            $table->dropColumn('account_head');
            $table->dropColumn('account_type');
        });
    }
}
