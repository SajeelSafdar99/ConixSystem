<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class payment_finance_sheet_subs extends Model
{
    use SoftDeletes;
	use Userstamps;

    protected $fillable = ['expense_id','unit','code','name','payment_method','amount','description','deleted_at','created_by', 'updated_by', 'deleted_by' , 'status', 'remarks','book', 'doc_no'];
}

