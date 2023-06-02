<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('media',function (Blueprint $table){
            $table->renameColumn('m_or_c','type');
            $table->renameColumn('moc_id','type_id');
//            $table->softDeletes();
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
        Schema::table('media',function (Blueprint $table){

            $table->renameColumn('type','m_or_c');
            $table->renameColumn('type_id','moc_id');
        });
    }
}
