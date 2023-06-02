<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class HrEmploymentUpdateDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hr_employments',function(Blueprint $table){
        $table->string('current_salary')->nullable();
        $table->string('barcode')->nullable();
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
            $table->dropColumn('current_salary');
            $table->dropColumn('barcode');
              });
    }
}
