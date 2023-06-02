<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMemPartnersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mem_partners', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('type')->nullable();
            $table->string('partner_name')->nullable();
            $table->string('facilitation')->nullable();
            $table->string('address')->nullable();
            $table->string('partner_mob_a')->nullable();
            $table->string('partner_mob_b')->nullable();
            $table->string('partner_tel_a')->nullable();
            $table->string('partner_email')->nullable();
            $table->string('website')->nullable();

            $table->string('focal_person_name')->nullable();
            $table->string('focal_mob_a')->nullable();
            $table->string('focal_mob_b')->nullable();
            $table->string('focal_tel_a')->nullable();
            $table->string('focal_email')->nullable();

            $table->text('documents')->nullable();

            $table->boolean('status')->nullable();

            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mem_partners');
    }
}
