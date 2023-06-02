<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeleteHrEmploymentFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hr_employments',function(Blueprint $table){
             $table->dropColumn('ref_name_a');
             $table->dropColumn('ref_add_a');
             $table->dropColumn('ref_mob_a');
             $table->dropColumn('ref_years_a');
             $table->dropColumn('ref_name_b');
             $table->dropColumn('ref_add_b');
             $table->dropColumn('ref_mob_b');
             $table->dropColumn('ref_years_b');
             $table->dropColumn('level_a');
             $table->dropColumn('institute_a');
             $table->dropColumn('course_a');
             $table->dropColumn('years_a');
             $table->dropColumn('type_a');
             $table->dropColumn('level_b');
             $table->dropColumn('institute_b');
             $table->dropColumn('course_b');
             $table->dropColumn('years_b');
             $table->dropColumn('type_b');
             $table->dropColumn('level_c');
             $table->dropColumn('institute_c');
             $table->dropColumn('course_c');
             $table->dropColumn('years_c');
             $table->dropColumn('type_c');
              $table->dropColumn('company_name_a');
             $table->dropColumn('hod_a');
             $table->dropColumn('company_add_a');
             $table->dropColumn('company_tel_a');
             $table->dropColumn('work_a');
             $table->dropColumn('employed_from_a');
             $table->dropColumn('employed_to_a');
             $table->dropColumn('salary_a');
             $table->dropColumn('leaving_reason_a');
             $table->dropColumn('company_name_b');
             $table->dropColumn('hod_b');
             $table->dropColumn('company_add_b');
             $table->dropColumn('company_tel_b');
             $table->dropColumn('work_b');
             $table->dropColumn('employed_from_b');
             $table->dropColumn('employed_to_b');
             $table->dropColumn('salary_b');
             $table->dropColumn('leaving_reason_b');
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
              $table->string('level_a')->nullable();
            $table->string('course_a')->nullable();
            $table->string('years_a')->nullable();
            $table->string('type_a')->nullable();
            $table->string('level_b')->nullable();
            $table->string('course_b')->nullable();
            $table->string('years_b')->nullable();
            $table->string('type_b')->nullable();
            $table->string('level_c')->nullable();
            $table->string('course_c')->nullable();
            $table->string('years_c')->nullable();
            $table->string('type_c')->nullable();
            $table->string('company_name_a')->nullable();
            $table->string('hod_a')->nullable();
            $table->string('company_add_a')->nullable();
            $table->string('company_tel_a')->nullable();
            $table->string('work_a')->nullable();
            $table->date('employed_from_a')->nullable();
            $table->date('employed_to_a')->nullable();
            $table->string('salary_a')->nullable();
            $table->string('leaving_reason_a')->nullable();
            $table->string('company_name_b')->nullable();
            $table->string('hod_b')->nullable();
            $table->string('company_add_b')->nullable();
            $table->string('company_tel_b')->nullable();
            $table->string('work_b')->nullable();
            $table->date('employed_from_b')->nullable();
            $table->date('employed_to_b')->nullable();
            $table->string('salary_b')->nullable();
            $table->string('leaving_reason_b')->nullable();
            $table->string('ref_name_a')->nullable();
            $table->string('ref_add_a')->nullable();
            $table->string('ref_mob_a')->nullable();
            $table->string('ref_years_a')->nullable();
            $table->string('ref_name_b')->nullable();
            $table->string('ref_add_b')->nullable();
            $table->string('ref_mob_b')->nullable();
            $table->string('ref_years_b')->nullable();
            $table->string('institute_a')->nullable();
           $table->string('institute_b')->nullable();
           $table->string('institute_c')->nullable();
        });
    }
}
