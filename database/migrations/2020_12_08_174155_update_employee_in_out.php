<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateEmployeeInOut extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employment_in_out', function (Blueprint $table) {
            //
            $table->dropColumn('in_out');
            $table->dateTime('in');
            $table->dateTime('out')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employment_in_out', function (Blueprint $table) {
            //
            $table->boolean('in_out');
            $table->dropColumn('in');
            $table->dropColumn('out');
        });
    }
}
