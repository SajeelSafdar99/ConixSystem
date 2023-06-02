<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateMediaTransTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('media',function (Blueprint $table){
            $table->bigInteger('trans_type')->nullable();
            $table->bigInteger('trans_type_id')->nullable();
            $table->bigInteger('trans_moc')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    { 
        Schema::table('media',function (Blueprint $table){
            $table->dropColumn('trans_type');
             $table->dropColumn('trans_type_id');
              $table->dropColumn('trans_moc');
        });
    }
}
