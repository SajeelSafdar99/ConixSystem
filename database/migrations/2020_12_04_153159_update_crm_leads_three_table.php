<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateCrmLeadsThreeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('crm_leads',function(Blueprint $table){
            $table->date('lead_date')->nullable();
            $table->bigInteger('source')->nullable();
            $table->string('city')->nullable();
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
            $table->dropColumn('lead_date');
            $table->dropColumn('source');
            $table->dropColumn('city');
        });
    }
}
