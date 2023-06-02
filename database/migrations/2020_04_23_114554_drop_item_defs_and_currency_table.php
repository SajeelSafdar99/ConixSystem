<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropItemDefsAndCurrencyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fnb_item_definitions',function(Blueprint $table){
            $table->dropColumn('discount');
            $table->dropColumn('tax');
            $table->dropColumn('tax_amount');
            $table->dropColumn('tax_percentage');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fnb_item_definitions',function(Blueprint $table){
            $$table->string('discount')->nullable();
            $table->string('tax')->nullable();
            $table->string('tax_amount')->nullable();
            $table->string('tax_percentage')->nullable();
        });
    }
}
