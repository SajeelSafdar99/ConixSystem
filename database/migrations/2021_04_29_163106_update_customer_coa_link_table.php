<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateCustomerCoaLinkTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   public function up()
    {
        Schema::table('customers',function (Blueprint $table){
            $table->string('account')->nullable();
        });
         Schema::table('guest_types',function (Blueprint $table){
            $table->dropColumn('account');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    { 
        Schema::table('guest_types',function (Blueprint $table){
            $table->string('account')->nullable();
        });
        Schema::table('customers',function (Blueprint $table){
            $table->dropColumn('account');
        });

    }
}
