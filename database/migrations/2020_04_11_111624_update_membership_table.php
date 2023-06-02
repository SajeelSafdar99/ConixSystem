<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateMembershipTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('memberships',function(Blueprint $table){
            $table->string('active_remarks')->nullable();
             $table->date('from')->nullable();
             $table->date('to')->nullable();
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
            $table->dropColumn('active_remarks');
            $table->dropColumn('from');
            $table->dropColumn('to');
        });
    }
}
