<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateFnbPredefinedValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    Schema::table('fnb_predefined_values',function(Blueprint $table){
            $table->string('service_amount')->nullable();
            $table->string('service_percentage')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fnb_predefined_values',function(Blueprint $table){
            $table->dropColumn('service_amount');
            $table->dropColumn('service_percentage');
        });
    }
}
