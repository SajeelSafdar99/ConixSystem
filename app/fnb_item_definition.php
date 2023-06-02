<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class fnb_item_definition extends Model
{
	use SoftDeletes;
	use Userstamps;
    protected $fillable = ['category','sub_category','manufacturer','item_code', 'item_details', 'opening_stock', 'purchase_price', 'sale_price', 'unit','product_classification', 'remarks', 'deleted_at', 'created_by', 'updated_by', 'deleted_by', 'discountable','taxable','discount_amount','discount_percentage', 'status','salable', 'purchasable', 'returnable', 'coa_code'];

  /*   public function categorycheck(){
        return $this->hasOne('App\fnb_item_category','id','category');

    }
    public function subcategorycheck(){
        return $this->hasOne('App\fnb_item_sub_category','id','sub_category');

    }*/
}
