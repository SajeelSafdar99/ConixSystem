<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class fnb_predefined_value extends Model
{
	use SoftDeletes;
	use Userstamps;
    protected $fillable = ['discount_amount','discount_percentage','tax_amount', 'tax_percentage', 'deleted_at', 'created_by', 'updated_by', 'deleted_by','service_amount' ,'service_percentage', 'take_away_tax', 'take_away_tax_pct', 'home_del_tax', 'home_del_tax_pct', 'currency', 'printer', 'print_limit', 'xp_printer', 'store_location', 'department', 'default_hours', 'default_offs', 'include_overtime','fnb_due','rooms_due', 'cashrec_due', 'cost_center', 'xp_printer_two'];
}
