<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateCrmLeadsTwoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
    {
        Schema::table('crm_leads',function(Blueprint $table){
            $table->bigInteger('call_status')->nullable();
            $table->timestamp('follow_up')->nullable();
            $table->timestamp('call_time')->nullable();
            $table->timestamp('next_visit')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('crm_leads',function(Blueprint $table){
            $table->dropColumn('call_status');
            $table->dropColumn('follow_up');
            $table->dropColumn('call_time');
            $table->dropColumn('next_visit');
        });
    }
}
