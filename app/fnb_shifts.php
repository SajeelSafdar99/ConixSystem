<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class fnb_shifts extends Model
{
	use SoftDeletes;
	use Userstamps;
    protected $fillable = ['date','deleted_at', 'created_by', 'updated_by', 'deleted_by'];
}
