<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Wildside\Userstamps\Userstamps;

class store_sales_subs extends Model
{
	use Userstamps;
    protected $fillable = ['sale_id', 'item_code','item_details','qty','purchase_price', 'sale_price','sub_total_price','instructions', 'created_by', 'updated_by', 'store_location', 'department', 'date', 'remark', 'aftercancel', 'status', 'unit', 'service_charges', 'discount', 'tax', 'cost_center'];


    public function saleid(){
        return $this->hasOne('App\store_sale','id','sale_id');

    }
}
