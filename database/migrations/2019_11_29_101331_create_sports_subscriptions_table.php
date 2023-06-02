<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSportsSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    { 
        Schema::create('sports_subscriptions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('code')->unique()->nullable();
            $table->string('desc')->nullable();
            $table->bigInteger('charges')->nullable();
            $table->boolean('status')->nullable();

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
        Schema::dropIfExists('sports_subscriptions');
    }
}
