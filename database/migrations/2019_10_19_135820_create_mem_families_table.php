<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMemFamiliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mem_families', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('member_id')->unsigned()->nullable();
            $table->foreign('member_id')->references('id')->on('memberships')->onDelete('set null')->onUpdate('cascade');
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
            $table->bigInteger('sup_card_no')->unique()->nullable();
            $table->enum('card_status', ['Issued', 'Printed', 'Applied'])->default('Issued')->nullable();
            $table->date('sup_card_issue')->nullable();
            $table->date('sup_card_exp')->nullable();
            $table->string('sup_barcode')->unique();
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
        Schema::dropIfExists('mem_families');
    }
}
