<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateEntAllTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fnb_sales',function(Blueprint $table){
             $table->tinyInteger('ent')->default(0);
             $table->timestamp('generated_at')->nullable();
        });

        Schema::table('transactions',function(Blueprint $table){
            $table->tinyInteger('ent')->default(0);
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
            $table->dropColumn('ent');
            $table->dropColumn('generated_at');
        });

        Schema::table('transactions',function(Blueprint $table){
            $table->dropColumn('ent');
        });
    }
}
