<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHrJobSubsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hr_job_subs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('employee_id')->nullable();
            $table->string('company_name')->nullable();
            $table->string('hod')->nullable();
            $table->string('address')->nullable();
            $table->string('contact')->nullable();
            $table->string('work')->nullable();
             $table->date('employed_from')->nullable();
            $table->date('employed_to')->nullable();
            $table->bigInteger('salary')->nullable();
            $table->string('reason')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hr_job_subs');
    }
}
