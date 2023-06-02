<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class fnb_table_reservation extends Model
{
	use SoftDeletes;
	use Userstamps;
    protected $fillable = ['invoice_no','date','time', 'restaurant_location', 'table_definition', 'waiter_definition', 'order_type', 'account_head','account_type', 'gross', 'discount', 'sub_total', 'tax', 'service_charges', 'grand_total', 'type', 'name', 'customer_id', 'covers', 'disc', 'category', 'sub_category', 'deleted_at', 'created_by', 'updated_by', 'deleted_by', 'disc_pc', 'discount_card_no', 'family', 'ledger_amount', 'completed', 'remarks', 'service_charges_pct', 'amount_received','member_id','confirmed' , 'reservation_no', 'reservation_date', 'nature_of_function', 'from_time', 'to_time', 'theme', 'arrangement_details'];

     public function salesubs(){

    	return $this->hasMany('App\fnb_sales_subs','sales_id','id');
    }
    public function member(){

         return $this->belongsTo('App\membership','customer_id');
    }

}
