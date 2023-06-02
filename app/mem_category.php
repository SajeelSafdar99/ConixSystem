<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class mem_category extends Model
{
	use SoftDeletes;

use Userstamps;
    protected $fillable = ['unique_code','desc','fee', 'monthly_sub_fee','status', 'deleted_at','created_by', 'updated_by', 'deleted_by','account', 'name'];
}
