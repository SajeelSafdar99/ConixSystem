<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MembershipsMaintenanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('memberships', function (Blueprint $table) {
        $table->string('mem_fee')->nullable();
        $table->string('additional_mem')->nullable();
        $table->string('additional_mem_remarks')->nullable();
        
        $table->string('mem_discount')->nullable();
        $table->string('mem_discount_remarks')->nullable();
        $table->string('total')->nullable();

        $table->string('maintenance_amount')->nullable();
        $table->string('additional_mt')->nullable();
        $table->string('additional_mt_remarks')->nullable();

        $table->string('mt_discount')->nullable();
        $table->string('mt_discount_remarks')->nullable();
        $table->string('total_maintenance')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('memberships', function (Blueprint $table) {
        $table->string('mem_fee')->nullable();
        $table->string('additional_mem')->nullable();
        $table->string('additional_mem_remarks')->nullable();
        
        $table->string('mem_discount')->nullable();
        $table->string('mem_discount_remarks')->nullable();
        $table->string('total')->nullable();

        $table->string('maintenance_amount')->nullable();
        $table->string('additional_mt')->nullable();
        $table->string('additional_mt_remarks')->nullable();

        $table->string('mt_discount')->nullable();
        $table->string('mt_discount_remarks')->nullable();
        $table->string('total_maintenance')->nullable();
        
        });
    }
}
