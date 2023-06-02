<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;
 
class hr_reference_subs extends Model
{
	use SoftDeletes;

    use Userstamps;
    protected $fillable = ['employee_id', 'name', 'address','contact', 'years','created_by','updated_by', 'deleted_by'];



}
