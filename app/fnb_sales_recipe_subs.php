<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\SoftDeletes;

class fnb_sales_recipe_subs extends Model
{
	use Userstamps;
	use SoftDeletes;
    protected $fillable = ['item_id', 'item_code','qty','created_by', 'updated_by', 'purchase_price', 'unit', 'deleted_at','deleted_by', 'sub_total_price'];

}
