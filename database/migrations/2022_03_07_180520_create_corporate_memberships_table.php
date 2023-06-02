<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCorporateMembershipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('corporate_memberships', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('application_no')->unique()->nullable();
            $table->date('application_date')->nullable();
            $table->string('mem_no')->nullable();
            $table->date('membership_date')->nullable();
            $table->string('applicant_name')->nullable();
            $table->string('mem_category_id')->nullable();
            $table->bigInteger('mem_classification_id')->unsigned()->nullable();
            $table->foreign('mem_classification_id')->references('id')->on('mem_classifications')->onDelete('set null')->onUpdate('cascade')->nullable();
            $table->string('status_remarks')->nullable();
            $table->string('mem_unique_code')->unique()->nullable();
            $table->enum('card_status', ['In-Process', 'Printed', 'Received', 'Issued', 'Re-Printed'])->default('In-Process')->nullable();
            $table->string('father_name')->nullable();
            $table->string('father_mem_no')->unique()->nullable();
            $table->string('cnic')->nullable();
            $table->date('date_of_birth')->nullable();
             $table->enum('gender', ['Male', 'Female', 'Other'])->default('Male')->nullable();
            $table->string('education')->nullable();
            $table->string('ntn')->nullable();
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

  $table->string('per_address')->nullable();
  $table->string('per_city')->nullable();
  $table->string('per_country')->nullable();
  $table->string('cur_address')->nullable();
  $table->string('cur_city')->nullable();
  $table->string('cur_country')->nullable();
 

        $table->string('mem_fee')->nullable();
        $table->string('additional_mem')->nullable();
        $table->string('additional_mem_remarks')->nullable();
        $table->string('mem_discount')->nullable();
        $table->string('mem_discount_remarks')->nullable();
        $table->integer('total')->nullable();
        $table->integer('maintenance_amount')->nullable();
        $table->string('additional_mt')->nullable();
        $table->string('additional_mt_remarks')->nullable();
        $table->string('mt_discount')->nullable();
        $table->string('mt_discount_remarks')->nullable();
        $table->integer('total_maintenance')->nullable();
         

            $table->date('card_exp')->nullable();
            $table->decimal('maintenance_per_day', 8, 2)->nullable();
            $table->string('active_remarks')->nullable();
            $table->date('from')->nullable();
            $table->date('to')->nullable();
            $table->string('emergency_name')->nullable();
            $table->string('emergency_relation')->nullable();
            $table->string('emergency_contact')->nullable();
            $table->string('passport_no')->nullable();


            $table->string('title')->nullable();
            $table->string('first_name')->nullable();
            $table->string('middle_name')->nullable();
            $table->string('name_comment')->nullable();
            $table->bigInteger('credit_limit')->nullable();

            $table->bigInteger('kinship')->nullable();
             $table->bigInteger('transferred_from')->nullable();
             $table->bigInteger('done_by')->nullable();
            
             $table->string('coa_category_id')->nullable();

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
        Schema::dropIfExists('corporate_memberships');
    }
}
