<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Wildside\Userstamps\Userstamps;

class crm_visit_details extends Model
{
	use Userstamps;
    protected $fillable = ['lead_id', 'advance_amount', 'remaining_amount', 'visit_date', 'next_visit','created_by', 'updated_by', 'membership_amount', 'visit_time', 'remarks'];

    public function leadid(){
        return $this->hasOne('App\crm_lead','id','lead_id');
    }

}
