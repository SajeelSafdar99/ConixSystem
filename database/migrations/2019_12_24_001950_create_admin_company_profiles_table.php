<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminCompanyProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_company_profiles', function (Blueprint $table) {
         $table->bigIncrements('id');
         $table->text('company_logo')->nullable();
         $table->string('company_name')->nullable();
         $table->string('company_address')->nullable();
         $table->string('company_city')->nullable();
        $table->string('company_number')->nullable();
         $table->string('company_email')->nullable();
         $table->string('company_website')->nullable();

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
        Schema::dropIfExists('admin_company_profiles');
    }
}
