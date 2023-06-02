<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Wildside\Userstamps\Userstamps;

class crm_call_detail extends Model
{
	use Userstamps;
    protected $fillable = ['lead_id', 'call_status', 'call_time', 'next_visit', 'follow_up', 'remarks','created_by', 'updated_by'];

    public function leadid(){
        return $this->hasOne('App\crm_lead','id','lead_id');
    }

}
