<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateMemFamilyGenderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::table('mem_families', function (Blueprint $table) {
            $table->enum('gender', ['Male', 'Female', 'Other'])->default('Male')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mem_families',function(Blueprint $table){
            $table->dropColumn('gender');
         
        });
    }
}
