<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class finance_payment_receipt extends Model
{
	use SoftDeletes;

use Userstamps;

     protected $fillable = ['receipt_type', 'customer_id', 'invoice_no','invoice_date','guest_name','mem_number','guest_address','guest_contact', 'ledger_amount', 'family', 'payment_received_for', 'surcharge','total','payment_method', 'payment_mode_details', 'total_amount', 'remarks', 'amount_in_words', 'payment_details', 'deleted_at', 'surcharge_percentage', 'account', 'employee_id','created_by', 'updated_by', 'deleted_by', 'person_id', 'coa_trans_type', 'coa_code', 'advance'];

    public function customer(){

         return $this->belongsTo('App\customer');
    }  public function member(){

         return $this->belongsTo('App\membership','mem_number');
    }
    public function employee(){

         return $this->belongsTo('App\hr_employment');
    }
    public function person(){

         return $this->belongsTo('App\finance_ledger_person');
    }
    public function account_details(){

         return $this->belongsTo('App\finance_account_type');
    }
    public function transactions(){
        return $this->hasMany('App\transactions','receipt_id');
    }
}

