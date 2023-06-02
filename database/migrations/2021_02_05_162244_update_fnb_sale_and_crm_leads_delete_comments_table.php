<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateFnbSaleAndCrmLeadsDeleteCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fnb_sales',function(Blueprint $table){
            $table->string('delete_comments')->nullable();
        });

        Schema::table('crm_leads',function(Blueprint $table){
            $table->string('delete_comments')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fnb_sales',function(Blueprint $table){
            $table->dropColumn('delete_comments');
        });

        Schema::table('crm_leads',function(Blueprint $table){
            $table->dropColumn('delete_comments');
        });
    }
}
