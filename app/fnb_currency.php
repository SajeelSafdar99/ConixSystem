<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class fnb_currency extends Model
{
	use SoftDeletes;
	use Userstamps;
    protected $fillable = ['desc','code','status', 'deleted_at', 'created_by', 'updated_by', 'deleted_by'];
}
