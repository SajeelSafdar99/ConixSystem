<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateItemDefsAndCurrencyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fnb_currencies',function(Blueprint $table){
            $table->string('code')->nullable();
        });
        

        Schema::table('fnb_item_definitions',function(Blueprint $table){
            $table->boolean('discountable')->nullable();
            $table->boolean('taxable')->nullable();
            $table->string('discount')->nullable();
            $table->string('discount_amount')->nullable();
            $table->string('discount_percentage')->nullable();
            $table->string('tax')->nullable();
            $table->string('tax_amount')->nullable();
            $table->string('tax_percentage')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fnb_currencies',function(Blueprint $table){
            $table->dropColumn('code');
        });

        Schema::table('fnb_item_definitions',function(Blueprint $table){
            $table->dropColumn('discountable');
            $table->dropColumn('taxable');
            $table->dropColumn('discount');
            $table->dropColumn('discount_amount');
            $table->dropColumn('discount_percentage');
            $table->dropColumn('tax');
            $table->dropColumn('tax_amount');
            $table->dropColumn('tax_percentage');
        });
    }
}
