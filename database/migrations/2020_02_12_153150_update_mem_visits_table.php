<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateMemVisitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('mem_visits',function(Blueprint $table){
            $table->renameColumn('member_id','type_id');
            $table->renameColumn('mem_no','type');

            $table->dropColumn('member_name');
            $table->dropColumn('time');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('mem_visits',function(Blueprint $table){
            $table->renameColumn('type_id','member_id');
            $table->renameColumn('type','mem_no');

            $table->string('member_name')->nullable();
            $table->string('time')->nullable();
        });
    }
}
