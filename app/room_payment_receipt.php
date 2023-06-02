<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\payment_receipts_sub;
use Wildside\Userstamps\Userstamps;

class room_payment_receipt extends Model
{
	use SoftDeletes;
use Userstamps;

     protected $fillable = ['booking_id', 'receipt_type', 'customer_id', 'invoice_no','invoice_date','guest_name','mem_number','guest_address','guest_contact', 'ledger_amount', 'family', 'payment_received_for', 'surcharge','total','payment_method', 'payment_mode_details', 'total_amount', 'cheaque_no', 'remarks', 'amount_in_words', 'payment_details', 'deleted_at', 'surcharge_percentage','created_by', 'updated_by', 'deleted_by'];


      public function subscriptions(){

    	return $this->hasMany('App\payment_receipts_sub','payment_receipt_id','id');
    }
    public function customer(){

         return $this->belongsTo('App\customer');
    }  public function member(){

         return $this->belongsTo('App\membership','mem_number');
    }
}
 