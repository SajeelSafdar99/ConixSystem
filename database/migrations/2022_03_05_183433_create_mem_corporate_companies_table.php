<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMemCorporateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('mem_corporate_companies', function (Blueprint $table) {
             $table->bigIncrements('id');
            $table->string('name')->nullable();
             $table->string('profile')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('contact')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
             $table->string('ntn')->nullable();
             $table->boolean('status')->nullable();
            $table->text('company_logo')->nullable();
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
        Schema::dropIfExists('mem_corporate_companies');
    }
}
