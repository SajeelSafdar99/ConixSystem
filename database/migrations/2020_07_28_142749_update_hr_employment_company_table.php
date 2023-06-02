<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateHrEmploymentCompanyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hr_employments', function (Blueprint $table) {
            $table->string('company')->nullable();
            $table->string('subdepartment')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hr_employments', function (Blueprint $table) {
            $table->dropColumn('company');
            $table->dropColumn('subdepartment');
        });
    }
}
