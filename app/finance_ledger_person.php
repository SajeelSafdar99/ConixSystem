<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class finance_ledger_person extends Model
{
    use SoftDeletes;

use Userstamps;
    protected $fillable = ['person_no','person_name','person_address','person_cnic','person_contact','person_email', 'deleted_at','created_by', 'updated_by', 'deleted_by', 'account', 'acc_title', 'acc_no', 'branch_code', 'branch_address','contact_b','contact_c','ntn'];

     public function expenses()
    {
        return $this->hasMany('App\finance_expense','person_id')->whereNotNull('person_id');
    }

   public function expensesDocs(){
        return $this->hasMany('App\media','type_id')->where('type',15);
    } 




   /* public function puchasesDocs(){
        return $this->hasMany('App\media','type_id')->where('type',115);
    }*/
     public function puchasesDocs(){
        return $this->hasMany('App\media','trans_type_id')->where('trans_type',7);
    }

     public function generalVoucherDocs(){
        return $this->hasMany('App\media','type_id')->where('type',80);
    }

    public function transactions(){
        return $this->hasMany('App\transactions','trans_moc')->where('trans_moc_type',2);
    }
}
