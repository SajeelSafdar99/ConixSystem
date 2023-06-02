<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class fnb_delivery_rider extends Model
{
	use SoftDeletes;
	use Userstamps;
    protected $fillable = ['name','contact','restaurant_location', 'status', 'deleted_at', 'created_by', 'updated_by', 'deleted_by'];
}
