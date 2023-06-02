<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class store_purchases extends Model
{
	use SoftDeletes;
	use Userstamps;
    protected $fillable = ['invoice_date','unit','account', 'gross', 'discount','tax','additional_charges', 'grand_total', 'remarks','deleted_at', 'created_by', 'updated_by', 'deleted_by', 'approved', 'amount_in_words', 'customer_id', 'coa_code'];

     public function storesubs(){

    	return $this->hasMany('App\store_purchases_subs','purchase_id','id');
    }

      public function ledgerperson(){

    return $this->belongsTo('App\finance_ledger_person','customer_id');
} 

 public function puchasesDocs(){
        return $this->hasMany('App\media','trans_type_id')->where('trans_type',7);
    }
   
}
