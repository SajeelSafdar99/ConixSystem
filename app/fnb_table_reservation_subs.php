<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Wildside\Userstamps\Userstamps;

class fnb_table_reservation_subs extends Model
{
	use Userstamps;
    protected $fillable = ['sales_id', 'qty', 'item_code', 'item_details', 'sale_price', 'total', 'instruction', 'created_by', 'updated_by','sub_total_price', 'kot_no', 'item_discount', 'status', 'saved', 'remark', 'aftercancel', 'subcategory', 'date'];


    public function saleid(){
        return $this->hasOne('App\fnb_sale','id','sales_id');

    }
}
