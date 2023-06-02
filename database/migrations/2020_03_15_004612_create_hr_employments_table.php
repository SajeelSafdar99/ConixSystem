<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHrEmploymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hr_employments', function (Blueprint $table) {
            $table->bigIncrements('id');
             $table->bigInteger('application_no')->unique()->nullable();
            $table->string('name')->nullable();
            $table->string('father_name')->nullable();
            $table->string('cnic')->nullable();
            $table->string('gender')->nullable();
            $table->string('age')->nullable();
            $table->string('license')->nullable();
            $table->string('license_no')->nullable();
            $table->string('bank_details')->nullable();
            $table->string('vehicle_details')->nullable();
            $table->string('learn_of_org')->nullable();
            $table->string('anyone_in_org')->nullable();
            $table->string('crime')->nullable();
            $table->string('crime_details')->nullable();
            $table->boolean('active')->nullable();
            $table->text('picture')->nullable();
            $table->string('mob_a')->nullable();
            $table->string('mob_b')->nullable();
            $table->string('tel_a')->nullable();
            $table->string('tel_b')->nullable();
            $table->string('email')->nullable();
            $table->string('cur_address')->nullable();
            $table->string('cur_city')->nullable();
            $table->string('cur_country')->nullable();
            $table->string('per_address')->nullable();
            $table->string('per_city')->nullable();
            $table->string('per_country')->nullable();
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
            $table->string('remarks')->nullable();
            
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hr_employments');
    }
}
