<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;
use Mpdf\Tag\P;

class transactions extends Model
{
    use SoftDeletes;
    use Userstamps;
    protected $table="transactions";
    protected $fillable = ['id','debit_or_credit', 'trans_type','link_detail', 'trans_type_id', 'trans_amount','trans_moc','trans_moc_type','receipt_id', 'deleted_at', 'created_by', 'updated_by','deleted_by','is_active', 'date', 'ent', 'trans_moc_category', 'pos_location', 'payment_method', 'unit', 'account', 'type','trans_coa'];

    public function getDetailsAttribute()
    {
//        if($this->trans_type==1 && $this->debit_or_credit==1){
////            return    $this->hasOne('App\room_booking','id','trans_type_id')->first()->toArray();
//
//        }else if($this->trans_type==2 && $this->debit_or_credit==1){
//
//            return    $this->hasOne('App\event_booking','id','trans_type_id')->first()->toArray();
//        } else if($this->trans_type==3 && $this->debit_or_credit==1){
////            return $this->hasOne('App\finance_invoice','id','trans_type_id')->first()->toArray();
//        }
//        elseif($this->debit_or_credit==0 && $this->receipt_id){
//                         return    $this->hasOne('App\finance_cash_receipt','id','receipt_id')->first()->toArray();
//
//        }
//        else{
//            return null;
////cashr
//        }
        $a=trans_type::find($this->trans_type);
        if(isset($a->table_name)){

            if($this->debit_or_credit==1){

                $d=$this->hasOne("App\\$a->table_name",'id','trans_type_id')->first();
            }
            elseif($this->debit_or_credit==0){

                $d=    $this->hasOne('App\finance_cash_receipt','id','receipt_id')->first();
            }


            if($d){
                return $d->toArray();
            }
            else{
                return null;
            }
        }
        else{
            return null;
        }
    }

    public function roomBookingAttribute(){
        return  $this->hasOne('App\room_booking','id','trans_type_id');
    }
    public function getRelateReceiptAttribute()
    {
        $d=[];

       if($this->debit_or_credit==1){
            $d= $this->hasMany('App\trans_relations','invoice','id')->get()->pluck('receipt');
        }
        else if($this->debit_or_credit==0){
            $d= $this->hasMany('App\trans_relations','receipt','id')->get()->pluck('invoice');
        }
/*
 if($this->debit_or_credit==1){
            $d= $this->hasMany('App\trans_relations','invoice','id')->get()->pluck('receipt');
        }
        else if($this->debit_or_credit==0){
            $d= $this->hasMany('App\trans_relations','receipt','id')->get()->pluck('invoice');
        }*/


        if($d){
            return  $d;
        }
        else{
            return null;
//cashr
        }
    }
 
    public function receipts(){
        return $this->hasMany('App\transactions', 'trans_type_id', 'trans_type_id')->where('type','=',1);
    }
   public function receipts2(){
        return $this->hasMany('App\transactions', 'trans_type_id', 'trans_type_id')->where('type','=',1);
    }
      public function receiptDetails2(){
        return $this->hasMany('App\transactions', 'trans_type_id', 'trans_type_id')->where('type','=',2);
    }
     
     public function receiptDetails(){
        return $this->hasMany('App\transactions',  'trans_type_id', 'trans_type_id')->where('type','=',2);
    }
 /*    public function discountDetails(){
        return $this->hasMany('App\transactions',  'trans_moc', 'trans_moc')->where('type','=',7)->where('trans_type','=',28)->where('debit_or_credit','=',0);
    }*/



    public function advances2(){
        return $this->hasMany('App\transactions', 'trans_type', 'trans_type')->where('type','=',7);
    }
     public function discounts2(){
        return $this->hasMany('App\transactions', 'trans_type', 'trans_type')->where('type','=',7);
    }
 


    

     public function payments(){
        return $this->hasMany('App\transactions', 'trans_type_id', 'trans_type_id')->whereIn('type',[4,6]);
    }
    public function payments2(){
        return $this->hasMany('App\transactions', 'trans_type_id', 'trans_type_id')->whereIn('type',[4,6]);
    }
      public function paymentDetails2(){
        return $this->hasMany('App\transactions', 'trans_type_id', 'trans_type_id')->where('type','=',5);
    }
       public function paymentDetails(){
        return $this->hasMany('App\transactions',  'trans_type_id', 'trans_type_id')->where('type','=',5);
    }




  

   public function receiptsp(){
        return $this->hasMany('App\trans_relations','invoice','id');
    }
    public function receipts2p(){
        return $this->hasMany('App\trans_relations','invoice','id');
    }

    
    public function type(){
        return $this->hasOne('App\trans_type','id','trans_type');
    }
    public function accounts(){
        return $this->hasOne('App\finance_account_type','id','trans_type_id');

    }
    public function member(){
        return   $this->hasOne('App\membership','id','trans_moc');

    } public function customer(){

        return   $this->belongsTo('App\customer','trans_moc','id');

    } public function employee(){

        return   $this->belongsTo('App\hr_employment','trans_moc','id');

    } public function person(){

        return   $this->belongsTo('App\finance_ledger_person','trans_moc','id');

    }
    public function getNameAttribute(){
//        echo $this->id;
        if($this->trans_moc_type==0){
//            echo $this->id;
           return $this->member->applicant_name;
        } if($this->trans_moc_type==1){
            return $this->customer->customer_name;

        }
        if($this->trans_moc_type==2){
            return $this->person->person_name;

        }
        if($this->trans_moc_type==3){
            return $this->employee->name;
        }
        if($this->trans_moc_type==4){
//            dd( $this->accounts->name);
          //     dd(finance_general_voucher::find($this->receipt_id));
           return finance_general_voucher::find($this->receipt_id)->name;
        }
    }
    public function getUTypeAttribute(){
        if($this->trans_moc_type==0){
//            echo $this->id;
           return 'Member';
        } if($this->trans_moc_type==1){
//            return $this->customer->customer_name;
            return 'Customer';

        }
        if($this->trans_moc_type==3){
            return $this->employee->name;
            return 'Employee';
        }
        if($this->trans_moc_type==2){
            return $this->person->person_name;
            return 'Ledger A/c';
        }
        if($this->trans_moc_type==4){
//            return $this->person->person_name;
            return 'Account Types';
        }
    }
    /**
     * Convert the model instance to an array.
     *
     * @param bool $raw If set to true, mutate attributes and add appends.
     * @return array
     */
    public function toArray($raw = false)
    {
        $m=Parent::toArray();

        $x= $this->getMutatedAttributes();


        if(1==1){
            foreach ($x as $y){
                $m[$y]=$this->getAttributeValue($y);
            }
        }

        return $m;

    }

}
