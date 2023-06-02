<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateFnbPredefinedValues2Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
    {
    Schema::table('fnb_predefined_values',function(Blueprint $table){
            $table->string('take_away_tax')->nullable();
            $table->string('take_away_tax_pct')->nullable();
            $table->string('home_del_tax')->nullable();
            $table->string('home_del_tax_pct')->nullable();
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
            $table->dropColumn('take_away_tax');
            $table->dropColumn('take_away_tax_pct');
            $table->dropColumn('home_del_tax');
            $table->dropColumn('home_del_tax_pct');
        });
    }
}
