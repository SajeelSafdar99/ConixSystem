<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class fnb_table_definition extends Model
{
	use SoftDeletes;
	use Userstamps;
    protected $fillable = ['restaurant_location', 'desc', 'status', 'deleted_at', 'created_by', 'updated_by', 'deleted_by'];
}
