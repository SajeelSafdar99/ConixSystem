<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateCustomersReferenceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customers',function(Blueprint $table){
             $table->string('member_name')->nullable();
             $table->string('mem_no')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customers',function(Blueprint $table){
            $table->dropColumn('member_name');
            $table->dropColumn('mem_no');
        });
    }
}
