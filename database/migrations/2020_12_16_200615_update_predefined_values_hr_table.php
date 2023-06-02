<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdatePredefinedValuesHrTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
    {
        Schema::table('fnb_predefined_values',function(Blueprint $table){
            $table->bigInteger('default_hours')->nullable();
            $table->bigInteger('default_offs')->nullable();
            $table->enum('include_overtime', ['Yes', 'No'])->default('Yes')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fnb_predefined_values',function(Blueprint $table){
            $table->dropColumn('default_hours');
            $table->dropColumn('default_offs');
            $table->dropColumn('include_overtime');
        });
    }
}
