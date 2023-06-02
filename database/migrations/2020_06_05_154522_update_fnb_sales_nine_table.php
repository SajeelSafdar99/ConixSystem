<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateFnbSalesNineTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
      public function up()
    {
        Schema::table('fnb_sales',function(Blueprint $table){
            $table->bigInteger('service_charges_pct')->nullable();
            $table->bigInteger('tax_pct')->nullable();
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
            $table->dropColumn('service_charges_pct');
            $table->dropColumn('tax_pct');
        });
    }
}
