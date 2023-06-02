<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFinanceLedgerPeopleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('finance_ledger_people', function (Blueprint $table) {
            $table->bigIncrements('id');
         
            $table->string('person_no')->nullable();
            $table->string('person_name')->nullable();
            $table->string('person_address')->nullable();
            $table->string('person_cnic')->nullable();
            $table->string('person_contact')->nullable();
            $table->string('person_email')->nullable();

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
        Schema::dropIfExists('finance_ledger_people');
    }
}
