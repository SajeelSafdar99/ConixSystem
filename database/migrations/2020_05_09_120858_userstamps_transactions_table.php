<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserstampsTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transactions',function(Blueprint $table){
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
        });

        Schema::table('trans_relations',function(Blueprint $table){
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transactions',function(Blueprint $table){
            $table->dropColumn('created_by');
            $table->dropColumn('updated_by');
            $table->dropColumn('deleted_by');
        });

        Schema::table('trans_relations',function(Blueprint $table){
            $table->dropColumn('created_by');
            $table->dropColumn('updated_by');
        });
    }
}
