<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateKotrecOneTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('sqlite')->table('kotrec', function(Blueprint $table)
        {
            $table->boolean('xprider')->default(0);

});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         Schema::connection('sqlite')->table('kotrec', function(Blueprint $table)
        {
        $table->dropColumn('xprider');
        });
    }
}
