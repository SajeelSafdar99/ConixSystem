<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Wildside\Userstamps\Userstamps;

class store_purchases_subs extends Model
{
	use Userstamps;
    protected $fillable = ['purchase_id', 'item_code','item_details','qty', 'purchase_price','sub_total_price','instructions', 'created_by', 'updated_by', 'store_location', 'department', 'date', 'remark', 'aftercancel', 'status', 'unit', 'service_charges', 'discount', 'tax', 'cost_center'];


    public function purchaseid(){
        return $this->hasOne('App\store_purchases','id','purchase_id');

    }
}
