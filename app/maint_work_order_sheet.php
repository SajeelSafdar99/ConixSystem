<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class maint_work_order_sheet extends Model
{
	use SoftDeletes;
	use Userstamps;
    protected $fillable = ['serial_no','issue_date','department','description','remarks','deleted_at', 'created_by', 'updated_by', 'deleted_by'];
}
