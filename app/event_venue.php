<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class event_venue extends Model
{
	use SoftDeletes;
use Userstamps;
    protected $fillable = ['id','desc','status', 'deleted_at','created_by', 'updated_by', 'deleted_by'];
}
