<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Wildside\Userstamps\Userstamps;

class hr_employments_deduction_subs extends Model
{
	use Userstamps;
    protected $fillable = ['employee_id', 'deduction','details','charges_amount','created_by', 'updated_by'];

}
