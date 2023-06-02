<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateMaintWorkordersheetDeleteRemarksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('maint_work_order_sheets',function(Blueprint $table){
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
        Schema::table('maint_work_order_sheets',function(Blueprint $table){
            $table->dropColumn('remarks');
        });

    }
}
