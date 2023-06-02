<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SportsSubscriptionHelpingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sports_subscriptions', function (Blueprint $table) {
        $table->string('charges')->nullable();
         $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sports_subscriptions', function (Blueprint $table) {
        $table->string('charges')->nullable();
         $table->dropSoftDeletes();
        });
    }
}
