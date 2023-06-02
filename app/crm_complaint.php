<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class crm_complaint extends Model
{
	use SoftDeletes;

    use Userstamps;
    protected $fillable = ['subject','message', 'deleted_at','created_by', 'updated_by', 'deleted_by'];
}