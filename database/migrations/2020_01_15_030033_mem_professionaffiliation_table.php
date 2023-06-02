<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MemProfessionaffiliationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mem_professionaffiliation', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('member_id')->unsigned()->nullable();
            $table->foreign('member_id')->references('id')->on('memberships')->onDelete('set null')->onUpdate('cascade');

             $table->string('next_of_kin')->nullable();
            $table->string('kin_relation')->nullable();

$table->enum('bussiness', ['Businessman', 'Government Officer', 'Armed Forces Officer', 'Private Employee'])->default('Businessman')->nullable();
            $table->string('position')->nullable();
            $table->string('experience')->nullable();
            $table->string('income')->nullable();
            $table->enum('anymess', ['Yes', 'No'])->default('Yes')->nullable();
            $table->string('when')->nullable();
            $table->boolean('mem_result')->nullable();
            $table->string('reason')->nullable();

            $table->string('referal_mem_name')->nullable();
            $table->string('referal_mem_no')->nullable();
            $table->string('referal_relation')->nullable();
            $table->string('referal_contact')->nullable();

            $table->string('aff')->nullable();
            $table->string('aff_name')->nullable();
            $table->string('aff_period')->nullable();
            $table->enum('others', ['Yes', 'No'])->default('Yes')->nullable();
            $table->string('details')->nullable();
            $table->string('political_details')->nullable();
            $table->string('a')->nullable();
            $table->string('b')->nullable();
            $table->enum('abroad', ['Yes', 'No'])->default('Yes')->nullable();
            $table->enum('crime', ['Yes', 'No'])->default('Yes')->nullable();
            $table->string('abroad_details')->nullable();
            $table->string('crime_details')->nullable();
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
        Schema::dropIfExists('mem_professionaffiliation');
    }
}
