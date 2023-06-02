<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MemFamilymemberInitialTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mem_families', function (Blueprint $table) {
    $table->string('member_name')->nullable();
    $table->string('membership_number')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mem_families', function (Blueprint $table) {
    $table->string('member_name')->nullable();
    $table->string('membership_number')->nullable();
        });
    }
}
