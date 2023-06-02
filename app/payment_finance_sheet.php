<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class payment_finance_sheet extends Model
{
    use SoftDeletes;
	use Userstamps;

    protected $fillable = ['book','doc_no','dated','deleted_at','created_by', 'updated_by', 'deleted_by', 'comments'];

     public function paymentSheetSubs(){

    	return $this->hasMany('App\payment_finance_sheet_subs','expense_id','id');
    }
}
//sudo chmod -R 777 /your path to allow permissions to a folder or to make it writable
