<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class fnb_waitor_definition extends Model
{
	use SoftDeletes;
	use Userstamps;
    protected $fillable = ['name','contact','restaurant_location', 'status', 'deleted_at', 'created_by', 'updated_by', 'deleted_by', 'second_restaurant_location', 'third_restaurant_location'];
}
