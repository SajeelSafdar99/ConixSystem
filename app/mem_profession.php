<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class mem_profession extends Model
{
	use SoftDeletes;
    protected $fillable = ['member_id','next_of_kin','kin_relation', 'bussiness', 'position', 'experience', 'income', 'anymess', 'when', 'mem_result', 'reason', 'referal_mem_name', 'referal_mem_no', 'referal_relation', 'referal_contact', 'aff','aff_name','aff_period', 'others', 'details', 'political_details', 'a','b','abroad','crime','abroad_details', 'crime_details', 'deleted_at', 'organization_name'];
}
