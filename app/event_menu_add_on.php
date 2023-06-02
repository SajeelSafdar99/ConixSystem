<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class event_menu_add_on extends Model
{
	use SoftDeletes;

use Userstamps;
    protected $fillable = ['desc', 'charges', 'status', 'deleted_at','created_by', 'updated_by', 'deleted_by'];
}
