<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class event_rate_category extends Model
{
	use SoftDeletes;

use Userstamps;
    protected $fillable = ['code','desc','status', 'deleted_at','created_by', 'updated_by', 'deleted_by'];
}
