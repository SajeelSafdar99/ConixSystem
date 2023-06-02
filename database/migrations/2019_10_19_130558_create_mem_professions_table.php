<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMemProfessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mem_professions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('member_id')->unsigned()->nullable();
            $table->foreign('member_id')->references('id')->on('memberships')->onDelete('set null')->onUpdate('cascade');
            $table->string('occupation')->nullable();
            $table->string('position')->nullable();
            $table->bigInteger('experience')->nullable();

            $table->string('govt_department')->nullable();
            $table->string('govt_position')->nullable();
            $table->string('grade')->nullable();

            $table->string('army_rank')->nullable();
            $table->boolean('serving');
            $table->boolean('retired');

            $table->bigInteger('monthly_income')->nullable();
            $table->string('other_membership')->nullable();
            $table->string('when');
            $table->boolean('was_approved');
            $table->boolean('was_rejected');
            $table->string('reason')->nullable();
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
        Schema::dropIfExists('mem_professions');
    }
}
