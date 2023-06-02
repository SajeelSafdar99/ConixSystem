<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoreIssueNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store_issue_notes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('invoice_date')->nullable();
            $table->bigInteger('store_location')->nullable();
            $table->bigInteger('department')->nullable();
            $table->bigInteger('gross')->nullable();
            $table->bigInteger('discount')->nullable();
            $table->bigInteger('tax')->nullable();
            $table->bigInteger('grand_total')->nullable();
            $table->string('amount_in_words')->nullable();
            $table->string('remarks')->nullable();
            $table->tinyInteger('approved')->default(0);

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
        Schema::dropIfExists('store_issue_notes');
    }
}
