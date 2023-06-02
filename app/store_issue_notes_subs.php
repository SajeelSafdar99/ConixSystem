<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Wildside\Userstamps\Userstamps;

class store_issue_notes_subs extends Model
{
	use Userstamps;
    protected $fillable = ['issue_id', 'item_code','item_details','qty','purchase_price','sub_total_price','instructions', 'store_location', 'department', 'created_by', 'updated_by', 'date', 'remark', 'aftercancel', 'status', 'unit', 'old_purchase_price', 'cost_center'];


    public function issueid(){
        return $this->hasOne('App\store_issue_notes','id','issue_id');

    }
}
