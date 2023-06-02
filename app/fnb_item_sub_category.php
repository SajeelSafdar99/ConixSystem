<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class fnb_item_sub_category extends Model
{
	use SoftDeletes;
	use Userstamps;
    protected $fillable = ['item_category', 'desc','printer', 'status', 'deleted_at', 'created_by', 'updated_by', 'deleted_by'];
}