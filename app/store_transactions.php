<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;
use Mpdf\Tag\P;

class store_transactions extends Model
{
    use SoftDeletes;
    use Userstamps;
    protected $table="store_transactions";
    protected $fillable = ['id','date', 'in_or_out','item_code', 'qty', 'store_location','department','type','is_active', 'type_id', 'sub_id', 'item_coa_code', 'sale_price', 'purchase_price', 'unit', 'issue_price', 'purchase_ref'];

    // TYPE = 1 is for PURCHASES
    // TYPE  = 2 is for SALES
    // TYPE = 3 is for ISSUE NOTES
    // TYPE = 4 is for FNB SALES
}
