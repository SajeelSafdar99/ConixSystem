<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateFinanceGeneralVoucherTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('finance_general_vouchers',function (Blueprint $table){
            $table->renameColumn('mem_number','member_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('finance_general_vouchers',function (Blueprint $table){
            $table->renameColumn('member_id','mem_number');
        });
    }
}
