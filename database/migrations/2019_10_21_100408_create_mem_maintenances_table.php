<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMemMaintenancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mem_maintenances', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('member_id')->unsigned()->nullable();
            $table->foreign('member_id')->references('id')->on('memberships')->onDelete('set null')->onUpdate('cascade');
            
            $table->string('name')->nullable();
            $table->string('membership_number')->nullable();

            $table->bigInteger('membership_fee')->nullable();
            $table->bigInteger('addi_mem_charges');
                $table->string('addi_mem_remarks');
            $table->bigInteger('mem_discount');
                $table->string('mem_discount_remarks');
            $table->bigInteger('total_fee')->nullable();
            
            $table->bigInteger('amount')->nullable();
            $table->bigInteger('addi_mt_charges');
                $table->string('addi_mt_remarks');
            $table->bigInteger('mt_discount');
                $table->string('mt_discount_remarks');
            $table->bigInteger('total_maintenance')->nullable();
          
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
        Schema::dropIfExists('mem_maintenances');
    }
}
