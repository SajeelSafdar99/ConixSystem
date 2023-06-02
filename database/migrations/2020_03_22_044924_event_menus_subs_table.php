<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EventMenusSubsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_menus_subs', function (Blueprint $table) {
            $table->bigIncrements('id');
             $table->bigInteger('menu_id')->nullable();
            $table->string('item_name')->nullable();
            $table->string('item_charges')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
   public function down()
    {
        Schema::dropIfExists('event_menus_subs');
    }
}
