<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdatePredefinedXpTwo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
    {
        Schema::table('fnb_predefined_values',function (Blueprint $table){
            $table->string('xp_printer_two')->nullable();
        });

        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    { 

       Schema::table('fnb_predefined_values',function (Blueprint $table){
            $table->dropColumn('xp_printer_two');
        });
        
        
    }
}
