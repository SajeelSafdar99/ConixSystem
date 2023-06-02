<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class fnb_cake_booking extends Model
{
	use SoftDeletes;
	use Userstamps;
    protected $fillable = ['booking_no','booking_date','order_taker','type','name','customer_id','family','cake_type','flavor','topping','filling','icing','color','weight','instructions','attachment','special_display','delivery_date','pickup_time','receiver','delivery_address','note','total_amount','discount','tax','grand_total','payment_method','status','document','deleted_at', 'created_by', 'updated_by', 'deleted_by' , 'advance_paid', 'balance_amount', 'reason'];

     public function customer(){

        return $this->belongsTo('App\customer','customer_id');
    }  public function member(){

    return $this->belongsTo('App\membership','customer_id');
}
public function employee(){

    return $this->belongsTo('App\hr_employment','customer_id');
}

 public function CakeBookingDocs(){
        return $this->hasMany('App\media','trans_type_id')->where('trans_type',6);
    }


}
