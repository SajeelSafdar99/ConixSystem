<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MemProfessionSubsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mem_profession_subs', function (Blueprint $table) {
            $table->bigIncrements('id');
             $table->bigInteger('profession_id')->nullable();
            $table->string('member_or_not')->nullable();
            $table->string('club_name')->nullable();
            $table->string('club_mem_no')->nullable();
            $table->timestamps();
        });

        Schema::table('mem_professionaffiliations',function(Blueprint $table){
            $table->string('kin_contact')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mem_profession_subs');

        Schema::table('mem_professionaffiliations',function(Blueprint $table){
            $table->dropColumn('kin_contact');
        });
    }
}
