<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class finance_general_voucher extends Model
{
    use SoftDeletes;

use Userstamps;
    protected $fillable = ['invoice_no', 'invoice_date', 'voucher_type', 'invoice_type','name','address','cnic','contact','email', 'ledger_amount', 'person_id', 'customer_id', 'member_id','debit_amount','debit_details', 'credit_amount', 'credit_details', 'account_date', 'status', 'account', 'acc_details', 'remarks', 'documents', 'deleted_at','created_by', 'updated_by', 'deleted_by', 'employee_id', 'account_id', 'payment_method', 'unit'];

     public function customer(){

        return $this->belongsTo('App\customer');
    }  public function member(){

    return $this->belongsTo('App\membership','member_id');
}
	public function ledgerperson(){

    return $this->belongsTo('App\finance_ledger_person','person_id');
}
	public function employee(){
    return $this->belongsTo('App\hr_employment','employee_id');
}
public function accounttype(){
    return $this->hasOne('App\coa_accounts_control','code','account_id');
}


 public function generalVoucherDocs(){
        return $this->hasMany('App\media','trans_type_id')->where('trans_type',80);
    }

}
