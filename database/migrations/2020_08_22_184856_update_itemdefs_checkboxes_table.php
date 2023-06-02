<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateItemdefsCheckboxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fnb_item_definitions',function(Blueprint $table){
            $table->boolean('salable')->nullable();
            $table->boolean('purchasable')->nullable();
            $table->boolean('returnable')->nullable();
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
            $table->dropColumn('salable');
            $table->dropColumn('purchasable');
             $table->dropColumn('returnable');
        });
    }
}
