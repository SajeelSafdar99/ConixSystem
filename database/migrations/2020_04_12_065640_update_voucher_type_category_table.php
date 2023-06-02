<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateVoucherTypeCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('finance_voucher_types',function(Blueprint $table){
             $table->boolean('debit')->nullable();
             $table->boolean('credit')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('finance_voucher_types',function(Blueprint $table){
            $table->dropColumn('debit');
            $table->dropColumn('credit');
        });
    }
}
