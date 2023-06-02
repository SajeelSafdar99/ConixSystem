<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class hr_job_subs extends Model
{
	use SoftDeletes;

    use Userstamps;
    protected $fillable = ['employee_id', 'company_name', 'hod', 'address','contact', 'work', 'employed_from', 'employed_to', 'salary','reason', 'created_by','updated_by', 'deleted_by'];



}
