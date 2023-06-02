<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCrmVisitDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crm_visit_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('lead_id')->nullable();
            $table->bigInteger('advance_amount')->nullable();
            $table->bigInteger('remaining_amount')->nullable();
            $table->timestamp('visit_date')->nullable();
            $table->timestamp('next_visit')->nullable();
            
            $table->timestamps();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('crm_visit_details');
    }
}
