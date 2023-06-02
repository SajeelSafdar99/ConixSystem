<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateCrmLeadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('crm_leads',function(Blueprint $table){
            $table->bigInteger('assigned_to')->nullable();
            $table->bigInteger('assigned_by')->nullable();
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
            $table->dropColumn('assigned_to');
            $table->dropColumn('assigned_by');
        });
    }
}
