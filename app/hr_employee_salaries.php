<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class hr_employee_salaries extends Model
{
	use SoftDeletes;

    use Userstamps;
    protected $fillable = ['payroll_id','employee_id','current_salary','working_days','overtime_days','total_salary','payable_salary','hours','pay_date', 'deleted_at','created_by', 'updated_by', 'deleted_by'];

    public function employee(){
       return $this->belongsTo('App\hr_employment','employee_id');
    } 

}