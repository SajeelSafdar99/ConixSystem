<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateFnbItemCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::table('fnb_item_categories',function(Blueprint $table){
            $table->string('printer')->nullable();
            $table->string('printer_two')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fnb_item_categories',function(Blueprint $table){
            $table->dropColumn('printer');
            $table->dropColumn('printer_two');
        });
    }
}
