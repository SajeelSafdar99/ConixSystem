<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class mem_car extends Model
{
	use SoftDeletes;
	use Userstamps;
    protected $fillable = ['member_id','name','membership_number','familyforcar', 'contactforcar','addressforcar','owner_name','owner_cnic', 'car_makeover','car_model','car_color','car_no', 'engine_no','chassis_no','driver_name', 'driver_cnic','driver_relation','car_remarks', 'deleted_at', 'sticker_no', 'sticker_issue_date', 'sticker_exp_date', 'sticker_status','created_by', 'updated_by', 'deleted_by'];
}
