<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateCrmVisitDetailsCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('crm_visit_details',function (Blueprint $table){
            $table->timestamp('visit_time')->nullable();
            $table->string('remarks')->nullable();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    { 

       Schema::table('crm_visit_details',function (Blueprint $table){
            $table->dropColumn('visit_time');
            $table->dropColumn('remarks');
        });
        
    }
}
