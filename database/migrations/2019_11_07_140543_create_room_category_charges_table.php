<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoomCategoryChargesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('room_category_charges', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('room_category_id')->unsigned()->nullable();
            $table->foreign('room_category_id')->references('id')->on('room_categories')->onDelete('set null')->onUpdate('cascade')->nullable();

            $table->bigInteger('room_id')->unsigned()->nullable();
            $table->foreign('room_id')->references('id')->on('rooms')->onDelete('set null')->onUpdate('cascade')->nullable();

            $table->string('charges')->nullable();

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
        Schema::dropIfExists('room_category_charges');
    }
}
