<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class hr_employment extends Model
{
	use SoftDeletes;

use Userstamps;
    protected $fillable = ['application_no','name','father_name', 'cnic', 'gender', 'age','license', 'license_no', 'bank_details', 'vehicle_details', 'learn_of_org', 'anyone_in_org', 'crime', 'crime_details', 'active', 'picture', 'mob_a', 'mob_b', 'tel_a', 'tel_b', 'email', 'cur_address', 'cur_city', 'cur_country', 'per_address', 'per_city', 'per_country', 'level_a', 'course_a','years_a','type_a','level_b','course_b','years_b','type_b', 'level_c', 'course_c', 'years_c', 'type_c', 'company_name_a', 'hod_a', 'company_add_a', 'company_tel_a', 'work_a', 'employed_from_a', 'employed_to_a', 'salary_a', 'leaving_reason_a', 'company_name_b', 'hod_b', 'company_add_b', 'company_tel_b','work_b','employed_from_b','employed_to_b','salary_b', 'leaving_reason_b', 'ref_name_a', 'ref_add_a', 'ref_mob_a', 'ref_years_a', 'ref_name_b','ref_add_b', 'ref_mob_b', 'ref_years_b', 'remarks', 'deleted_at', 'current_salary', 'barcode', 'department', 'designation', 'institute_a', 'institute_b', 'institute_c','created_by', 'updated_by', 'deleted_by', 'company', 'subdepartment', 'total_addon_charges', 'total_salary', 'days', 'hours','date_of_joining', 'total_deduction_charges', 'account'];


public function hrcompany()
    {
        return $this->hasOne('App\coa_account','code', 'company');

    }


 /*public function hrcompany()
    {
        return $this->belongsTo('App\hr_company','company');

    }
*/
 public function  education(){
        return $this->hasMany('App\hr_education_subs','employee_id');
    }

     public function jobs(){
        return $this->hasMany('App\hr_job_subs','employee_id');
    }
  public function references(){
        return $this->hasMany('App\hr_reference_subs','employee_id');
    }


    public function employeeDocs(){
        return $this->hasMany('App\media','type_id')->where('type',55);
    }

     public function employeePic(){
        return $this->hasOne('App\media','type_id')->where('type',50);
    } public function departments(){
        return $this->hasOne('App\hr_department','id','department');
    }

     public function updateEmployeePic(){
        return $this->hasMany('App\media','type_id','id')->where('type',50);

    }
    public function checkins(){
        return $this->hasMany('App\employment_in_out','employee_id','id')->where('in_out',0);
    }
    public function checkouts(){
        return $this->hasMany('App\employment_in_out','employee_id','id')->where('in_out',1);
    }public function visits(){
        return $this->hasMany('App\employment_in_out','employee_id','id');
    }

    public function foodbills(){
        return $this->hasMany('App\fnb_sale','customer_id','id');
    }

    public function transactions(){
        return $this->hasMany('App\transactions','trans_moc')->where('trans_moc_type',3);
    }

     public function generalVoucherDocs(){
        return $this->hasMany('App\media','type_id')->where('type',83);
    }


    public function CakeBookingDocs(){
        return $this->hasMany('App\media','type_id')->where('type',103);
    }
 
   public function addons(){

        return $this->hasMany('App\hr_employments_subs','employee_id','id');
    }


      public function deductions(){

        return $this->hasMany('App\hr_employments_deduction_subs','employee_id','id');
    }


}
