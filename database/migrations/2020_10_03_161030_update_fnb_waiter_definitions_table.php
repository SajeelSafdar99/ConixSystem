<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateFnbWaiterDefinitionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fnb_waitor_definitions',function(Blueprint $table){
            $table->bigInteger('second_restaurant_location')->nullable();
            $table->bigInteger('third_restaurant_location')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         Schema::table('fnb_waitor_definitions',function(Blueprint $table){
            $table->dropColumn('second_restaurant_location');
            $table->dropColumn('third_restaurant_location');
        });
    }
}
