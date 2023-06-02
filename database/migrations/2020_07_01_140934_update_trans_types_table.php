<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTransTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('trans_types',function (Blueprint $table){
           $table->string('table_name')->nullable();
           $table->string('details')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('trans_types',function (Blueprint $table){
            $table->dropColumn('table_name');
            $table->dropColumn('details');
        });
    }
}
