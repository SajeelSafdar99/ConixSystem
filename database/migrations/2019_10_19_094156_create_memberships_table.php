<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMembershipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('memberships', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('application_no')->unique()->nullable();
            $table->date('application_date')->nullable();
            $table->string('mem_no')->nullable();
            $table->date('membership_date')->nullable();
            $table->string('applicant_name')->nullable();
            $table->bigInteger('mem_category_id')->unsigned()->nullable();
            $table->foreign('mem_category_id')->references('id')->on('mem_categories')->onDelete('set null')->onUpdate('cascade')->nullable();
            $table->bigInteger('mem_classification_id')->unsigned()->nullable();
            $table->foreign('mem_classification_id')->references('id')->on('mem_classifications')->onDelete('set null')->onUpdate('cascade')->nullable();
            $table->string('status_remarks')->nullable();
            $table->string('mem_unique_code')->unique()->nullable();
            $table->enum('card_status', ['Pending', 'Provisional', 'On Hold', 'Temporarily Suspended', 'Permanently Suspended', 'Approved'])->default('Pending')->nullable();
                   
            $table->string('father_name')->nullable();
            $table->string('father_mem_no')->unique()->nullable();
            $table->string('cnic')->nullable();
            $table->date('date_of_birth')->nullable();
             $table->enum('gender', ['Male', 'Female', 'Other'])->default('Male')->nullable();
            $table->string('education')->nullable();
            $table->bigInteger('ntn')->nullable();
            $table->string('reason')->nullable();
            $table->string('details')->nullable();
            $table->enum('blood_group', ['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-'])->default('A+')->nullable();
            
            $table->string('tel_a')->nullable();
            $table->string('tel_b')->nullable();
            $table->string('mob_a')->nullable();
            $table->string('mob_b')->nullable();
            $table->string('personal_email')->nullable();
            $table->string('official_email')->nullable();

            $table->boolean('card_issued')->nullable();
            $table->date('card_issue_date')->nullable();
            $table->string('mem_barcode')->unique()->nullable();
            $table->boolean('sup_card_issued')->nullable();
            $table->date('sup_card_date')->nullable();
            $table->text('mem_picture')->nullable();
            $table->string('remarks')->nullable();
            $table->boolean('active')->nullable();
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
        Schema::dropIfExists('memberships');
    }
}
