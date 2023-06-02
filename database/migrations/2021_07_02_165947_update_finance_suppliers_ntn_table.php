<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateFinanceSuppliersNtnTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
    {
        Schema::table('finance_ledger_people',function (Blueprint $table){
            $table->string('contact_b')->nullable();
            $table->string('contact_c')->nullable();
            $table->string('ntn')->nullable(); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    { 
        Schema::table('finance_ledger_people',function (Blueprint $table){
            $table->dropColumn('contact_b');
            $table->dropColumn('contact_c');
            $table->dropColumn('ntn');
        });
    }
}
