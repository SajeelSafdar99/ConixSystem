<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateHrEmploymentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hr_employments',function(Blueprint $table){
        $table->string('institute_a')->nullable();
        $table->string('institute_b')->nullable();
        $table->string('institute_c')->nullable();
        $table->string('department')->nullable();
        $table->string('designation')->nullable();
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
            $table->dropColumn('institute_a');
            $table->dropColumn('institute_a');
            $table->dropColumn('institute_a');
            $table->dropColumn('department');
            $table->dropColumn('designation');
              });
    }
}
