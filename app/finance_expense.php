<?php

namespace App;
 
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;
 
class finance_expense extends Model
{
    use SoftDeletes;
	use Userstamps;
 protected $table='finance_expense';
 protected $fillable = ['expense_no', 'expense_date', 'supplier_id', 'unit','code','name','amount','description','status', 'remarks', 'comments'];

   /* protected $fillable = ['ledger_person_id', 'person_id', 'person_name', 'invoice_no','invoice_date','person_address','person_cnic','person_contact','person_email', 'ledger_amount', 'expense_paid_for', 'expense_details', 'payment_method','payment_mode_details','total_amount', 'surcharge', 'total', 'amount_in_words', 'documents', 'remarks', 'deleted_at', 'account_head', 'account_type', 'account_date', 'surcharge_percentage','created_by', 'updated_by', 'deleted_by', 'expense_head'];*/
 public function expensesDocs(){
        return $this->hasMany('App\media','trans_type_id')->where('trans_type',9);
    }

    public function ledgerperson(){

    return $this->belongsTo('App\finance_ledger_person','supplier_id');
}

  public function expensesubs(){

    	return $this->hasMany('App\finance_expenses_subs','expense_id','id');
    }

}
//sudo chmod -R 777 /your path to allow permissions to a folder or to make it writable
