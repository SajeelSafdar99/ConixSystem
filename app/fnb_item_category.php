<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class fnb_item_category extends Model
{
	use SoftDeletes;
	use Userstamps;
    protected $fillable = ['desc','status', 'deleted_at', 'created_by', 'updated_by', 'deleted_by', 'printer', 'printer_two', 'pos_location'];

}
