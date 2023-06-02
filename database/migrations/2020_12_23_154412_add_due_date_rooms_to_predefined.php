<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDueDateRoomsToPredefined extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fnb_predefined_values', function (Blueprint $table) {
            //
            $table->date('rooms_due')->default('2020-01-01');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fnb_predefined_values', function (Blueprint $table) {
            //
            $table->dropColumn('rooms_due');
        });
    }
}
