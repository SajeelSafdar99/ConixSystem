<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateMembershipsAndMemfamilyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('memberships',function(Blueprint $table){
            $table->string('passport_no')->nullable();
        });

        Schema::table('mem_families',function(Blueprint $table){
            $table->string('passport_no')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('memberships',function(Blueprint $table){
            $table->dropColumn('passport_no');
        });

        Schema::table('mem_families',function(Blueprint $table){
            $table->dropColumn('passport_no');
        });
    }
}