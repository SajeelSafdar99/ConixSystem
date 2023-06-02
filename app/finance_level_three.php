<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class finance_level_three extends Model
{
    use SoftDeletes;
	use Userstamps;

    protected $fillable = ['level_two','desc','status', 'deleted_at','created_by', 'updated_by', 'deleted_by'];

}