<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateFnbRestaurantLocationsChecksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fnb_restaurant_locations',function(Blueprint $table){
            $table->boolean('restaurant')->nullable();
            $table->boolean('store')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fnb_restaurant_locations',function(Blueprint $table){
            $table->dropColumn('restaurant');
            $table->dropColumn('store');
        });
    }
}
