<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class hr_sub_department extends Model
{
	use SoftDeletes;
	use Userstamps;
    protected $fillable = ['department', 'desc', 'status', 'deleted_at', 'created_by', 'updated_by', 'deleted_by'];
}
