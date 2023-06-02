<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropMemProfessionSubsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mem_profession_subs',function(Blueprint $table){
            $table->dropColumn('member_or_not');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mem_profession_subs',function(Blueprint $table){
            $table->string('member_or_not')->nullable();
        });
    }
}
