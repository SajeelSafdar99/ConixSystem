<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHrReferenceSubsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hr_reference_subs', function (Blueprint $table) {
             $table->bigIncrements('id');
            $table->bigInteger('employee_id')->nullable();
            $table->string('name')->nullable();
            $table->string('address')->nullable();
            $table->string('contact')->nullable();
            $table->integer('years')->nullable();
            
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
        Schema::dropIfExists('hr_reference_subs');
    }
}
