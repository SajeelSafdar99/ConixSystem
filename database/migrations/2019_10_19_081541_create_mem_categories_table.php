<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMemCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mem_categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('code')->unique();
            $table->string('unique_code')->unique();
            $table->string('desc');
            $table->decimal('fee',50,2);
            $table->decimal('monthly_sub_fee',50,2)->unsigned()->default(0)->nullable();
            $table->boolean('status');
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
        Schema::dropIfExists('mem_categories');
    }
}
