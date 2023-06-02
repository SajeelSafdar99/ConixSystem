<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMemAffiliationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mem_affiliations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('member_id')->unsigned()->nullable();
            $table->foreign('member_id')->references('id')->on('memberships')->onDelete('set null')->onUpdate('cascade');
            $table->string('affiliation')->nullable();
            $table->string('name')->nullable();
            $table->string('period')->nullable();
            $table->boolean('other_club')->nullable();
            $table->string('details');
            $table->string('political_affiliation');
            $table->string('relative_a');
            $table->string('relative_b');
            $table->boolean('stayed_abroad')->nullable();
            $table->string('abroad_details');
            $table->boolean('criminal')->nullable();
            $table->string('criminal_details');
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
        Schema::dropIfExists('mem_affiliations');
    }
}
