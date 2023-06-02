<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MembershipsAddressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('memberships', function (Blueprint $table) {
        $table->string('per_address')->nullable();
        $table->string('per_city')->nullable();
        $table->string('per_country')->nullable();
        
        $table->string('cur_address')->nullable();
        $table->string('cur_city')->nullable();
        $table->string('cur_country')->nullable();
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
        $table->string('per_address')->nullable();
        $table->string('per_city')->nullable();
        $table->string('per_country')->nullable();
        
        $table->string('cur_address')->nullable();
        $table->string('cur_city')->nullable();
        $table->string('cur_country')->nullable();
        });
    }
}
