<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateSubscriptionTypesChargesFloatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
    {
        DB::statement('alter table sports_subscriptions modify charges DOUBLE(8,1) DEFAULT 0');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    { 
         Schema::table('sports_subscriptions',function (Blueprint $table){
             $table->string('charges')->change();
        });
    }
}
