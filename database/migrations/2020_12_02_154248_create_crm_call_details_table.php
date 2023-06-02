<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCrmCallDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crm_call_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('lead_id')->nullable();
            $table->bigInteger('call_status')->nullable();
            $table->timestamp('call_time')->nullable();
            $table->timestamp('next_visit')->nullable();
            $table->timestamp('follow_up')->nullable();
            $table->string('remarks')->nullable();

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
        Schema::dropIfExists('crm_call_details');
    }
}
