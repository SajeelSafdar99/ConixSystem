<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCorporateMemFamiliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('corporate_mem_families', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('member_id')->unsigned()->nullable();
            $table->foreign('member_id')->references('id')->on('corporate_memberships')->onDelete('set null')->onUpdate('cascade');
            $table->string('next_of_kin')->nullable();
            $table->string('relationship')->nullable();
            $table->string('name')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('fam_relationship')->nullable();
            $table->string('nationality')->nullable();
            $table->string('cnic')->nullable();
            $table->string('contact')->nullable();
            $table->enum('maritial_status', ['Single', 'Married', 'Divorced'])->default('Single')->nullable();
            $table->text('fam_picture')->nullable();
            $table->string('sup_card_no')->nullable();
            $table->enum('card_status', ['Issued', 'Applied', 'Printed', 'Re-Printed', 'Not Applied', 'Expired', 'Not Applicable'])->default('Issued')->nullable();
            $table->date('sup_card_issue')->nullable();
            $table->date('sup_card_exp')->nullable();
            $table->string('sup_barcode')->nullable();
            $table->boolean('status')->nullable();
            $table->string('member_name')->nullable();
            $table->string('membership_number')->nullable();
            $table->string('remarks')->nullable();
            $table->string('passport_no')->nullable();
            $table->string('title')->nullable();
            $table->string('first_name')->nullable();
            $table->string('middle_name')->nullable();
            $table->string('name_comment')->nullable();
            $table->enum('gender', ['Male', 'Female', 'Other'])->default('Male')->nullable();


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
        Schema::dropIfExists('corporate_mem_families');
    }
}
