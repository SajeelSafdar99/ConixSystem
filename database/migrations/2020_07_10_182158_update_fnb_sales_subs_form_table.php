<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateFnbSalesSubsFormTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fnb_sales_subs',function(Blueprint $table){
            $table->bigInteger('remark')->nullable();
            $table->boolean('aftercancel')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fnb_sales_subs',function(Blueprint $table){
            $table->dropColumn('remark');
            $table->dropColumn('aftercancel');
        });
    }
}
