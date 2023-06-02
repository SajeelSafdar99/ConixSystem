<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMemCarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mem_cars', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('member_id')->unsigned()->nullable();
            $table->foreign('member_id')->references('id')->on('memberships')->onDelete('set null')->onUpdate('cascade');
            
            $table->string('name')->nullable();
            $table->string('membership_number')->nullable();
            $table->string('familyforcar')->nullable();
            $table->string('contactforcar')->nullable();
            $table->string('addressforcar')->nullable();
            
            $table->string('owner_name')->nullable();
            $table->string('owner_cnic')->nullable();
            $table->string('car_makeover')->nullable();
            $table->string('car_model')->nullable();
            $table->string('car_color')->nullable();
            $table->string('car_no')->nullable();
            $table->string('engine_no')->nullable();
            $table->string('chassis_no')->nullable();

            $table->string('driver_name')->nullable();
            $table->string('driver_cnic')->nullable();
            $table->string('driver_relation')->nullable();

            $table->string('car_remarks');
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
        Schema::dropIfExists('mem_cars');
    }
}
