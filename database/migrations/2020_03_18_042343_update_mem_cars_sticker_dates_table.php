<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateMemCarsStickerDatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mem_cars',function(Blueprint $table){
            $table->date('sticker_issue_date')->nullable();
            $table->date('sticker_exp_date')->nullable();
            $table->boolean('sticker_status')->nullable();
             });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mem_cars',function(Blueprint $table){
            $table->dropColumn('sticker_issue_date');
            $table->dropColumn('sticker_exp_date');
            $table->dropColumn('sticker_status');
              });
    }
}
