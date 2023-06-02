<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class store_sales extends Model
{
	use SoftDeletes;
	use Userstamps;
    protected $fillable = ['invoice_date','unit', 'account','gross', 'discount','tax','additional_charges', 'grand_total', 'remarks','deleted_at', 'created_by', 'updated_by', 'deleted_by', 'approved', 'family', 'amount_in_words', 'customer_id', 'type', 'coa_code', 'purchase_ref'];

     public function storesubs(){

    	return $this->hasMany('App\store_sales_subs','sale_id','id');
    }

       public function customer(){

        return $this->belongsTo('App\customer','customer_id');
    }  public function member(){

    return $this->belongsTo('App\membership','customer_id');
}
public function employee(){

    return $this->belongsTo('App\hr_employment','customer_id');
}
   
    public function storeSalesDocs(){
        return $this->hasMany('App\media','trans_type_id')->where('trans_type',8);
    }

}
