<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateHrEmployeeAddonsTotalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hr_employments',function(Blueprint $table){
            $table->bigInteger('total_addon_charges')->nullable();
            $table->bigInteger('total_salary')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hr_employments',function(Blueprint $table){
            $table->dropColumn('total_addon_charges');
            $table->dropColumn('total_salary');
        });
    }
}
