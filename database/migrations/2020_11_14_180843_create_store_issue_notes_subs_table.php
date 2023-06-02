<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoreIssueNotesSubsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store_issue_notes_subs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('issue_id')->nullable();
            $table->string('item_code')->nullable();
            $table->string('item_details')->nullable();
            $table->bigInteger('qty')->nullable();
            $table->bigInteger('purchase_price')->nullable();
            $table->bigInteger('sub_total_price')->nullable();
            $table->string('instructions')->nullable();
            $table->bigInteger('store_location')->nullable();
            $table->bigInteger('department')->nullable();
            $table->timestamps();
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
        Schema::dropIfExists('store_issue_notes_subs');
    }
}
