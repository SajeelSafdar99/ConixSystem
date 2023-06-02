<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateHrEmploymentSalaryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hr_employments',function(Blueprint $table){
            $table->bigInteger('days')->nullable();
            $table->bigInteger('hours')->nullable();
        });

        Schema::table('hr_employments_subs',function(Blueprint $table){
            $table->bigInteger('trans_type')->nullable();
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
            $table->dropColumn('days');
            $table->dropColumn('hours');
        });

        Schema::table('hr_employments_subs',function(Blueprint $table){
            $table->dropColumn('trans_type');
        });
    }
}
