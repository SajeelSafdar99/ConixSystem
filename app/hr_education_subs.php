<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class hr_education_subs extends Model
{
	use SoftDeletes;

    use Userstamps;
    protected $fillable = ['employee_id', 'level_of_education', 'institute', 'course','years', 'type', 'created_by','updated_by', 'deleted_by'];



}
