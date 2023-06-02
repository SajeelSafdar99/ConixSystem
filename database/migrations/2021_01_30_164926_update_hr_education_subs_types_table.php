<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateHrEducationSubsTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
    {
        Schema::table('hr_education_subs',function(Blueprint $table){
              $table->string('level_of_education')->change();
              $table->string('type')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hr_education_subs',function(Blueprint $table){
            $table->integer('level_of_education')->change();
              $table->integer('type')->change();
        });
    }
}
