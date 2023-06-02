<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class finance_invoice extends Model
{
    use SoftDeletes;
    use Userstamps;
    protected $fillable = ['id','invoice_no','invoice_date', 'invoice_type', 'name', 'customer_id', 'member_id', 'mem_no', 'address', 'cnic', 'contact', 'email', 'family', 'ledger_amount', 'total', 'discount_amount', 'discount_details', 'extra_charges', 'extra_details', 'tax_charges', 'tax_details', 'grand_total', 'amount_in_words', 'comments', 'deleted_at','is_auto_generated', 'discount_percentage', 'extra_percentage', 'tax_percentage', 'charges_type_id', 'charges_amount', 'start_date', 'end_date', 'days', 'charges_total', 'charges_type', 'qty', 'created_by', 'updated_by', 'deleted_by', 'charges_type', 'start_date', 'end_date', 'days', 'qty', 'sub_total', 'account', 'paid_amount', 'receipt_id', 'receipt_date', 'status', 'per_day_amount', 'coa_code', 'corporate_id'];

  public function transactions(){
        return $this->hasMany('App\transactions',  'trans_type_id', 'id')->where('type','=',2)->where('debit_or_credit','=',0)->where('trans_type','=',4);
    }
    public function customer(){

         return $this->belongsTo('App\customer');
    }  public function member(){

         return $this->belongsTo('App\membership','member_id');
    }

    public function corporatemember(){

         return $this->belongsTo('App\corporateMembership','corporate_id');
    }
     public function familyD(){

         return $this->hasOne('App\mem_family','id','family');
    }

      public function cofamilyD(){

         return $this->hasOne('App\corporateMemFamily','id','family');
    }

    public function invoiceSubs(){
        return $this->hasMany('App\finance_invoice_subs','invoice_id','id');
    }
}
