<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMemDeleteRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tables=['mem_relations','mem_classifications','mem_categories','mem_club_facilities','memberships','mem_professions','mem_affiliations','mem_families','mem_referals','mem_cars'];
        foreach($tables as $t)
  {
         Schema::table($t, function (Blueprint $table) {
         $table->softDeletes();
        });

  }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
          $tables=['mem_relations','mem_classifications','mem_categories','mem_club_facilities','memberships','mem_professions','mem_affiliations','mem_families','mem_referals','mem_cars'];
        foreach($tables as $t)
  {
         Schema::table($t, function (Blueprint $table) {
         $table->dropSoftDeletes();
        });

  }
    }
}
