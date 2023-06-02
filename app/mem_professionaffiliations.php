<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Wildside\Userstamps\Userstamps;

class mem_professionaffiliations extends Model
{
  /*  use SoftDeletes;*/

use Userstamps;
    protected $fillable = ['member_id','next_of_kin','kin_relation', 'kin_contact', 'bussiness', 'position', 'experience', 'income', 'anymess', 'when', 'mem_result', 'reason', 'referal_mem_name', 'referal_mem_no', 'referal_relation', 'referal_contact', 'aff','aff_name','aff_period', 'club_name', 'others', 'details', 'political_details', 'a','b','abroad','crime','abroad_details', 'crime_details', 'organization_name','created_by', 'updated_by'];

   public function clubsubs(){

    	return $this->hasMany('App\mem_profession_subs','profession_id','member_id');
    }
}
