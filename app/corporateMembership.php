<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class corporateMembership extends Model
{
    use SoftDeletes;

use Userstamps;
    protected $fillable = ['application_no','application_date','mem_no', 'membership_date', 'applicant_name', 'mem_category_id','status_remarks', 'mem_classification_id', 'mem_unique_code', 'status', 'father_name', 'father_mem_no', 'cnic', 'date_of_birth', 'gender', 'education', 'ntn', 'reason', 'details', 'blood_group', 'card_issued', 'card_issue_date', 'card_exp', 'mem_barcode', 'sup_card_issued', 'sup_card_date', 'mem_picture','tel_a','tel_b','mob_a','mob_b','personal_email','official_email', 'remarks', 'active', 'per_address', 'per_city', 'per_country', 'cur_address', 'cur_city', 'cur_country', 'mem_fee', 'additional_mem', 'additional_mem_remarks', 'mem_discount', 'mem_discount_remarks', 'total', 'maintenance_amount', 'additional_mt', 'additional_mt_remarks', 'mt_discount', 'mt_discount_remarks', 'total_maintenance','maintenance_per_day', 'deleted_at', 'active_remarks', 'from', 'to', 'emergency_name', 'emergency_relation', 'emergency_contact', 'passport_no', 'card_status','created_by', 'updated_by', 'deleted_by', 'title', 'first_name', 'middle_name', 'name_comment', 'credit_limit','kinship', 'transferred_from', 'done_by', 'coa_category_id', 'corporate_company'];

    public function getTableColumns() {
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    }
   /* public function updatepp(){
        return $this->hasMany('App\media','type_id','id')->where('type',11);

    }*/

    public function mem_status()
    {
        return $this->belongsTo('App\mem_status','active');

    }
     public function profession()
    {
        return $this->hasOne('App\mem_professionaffiliations','member_id');

    }
    public function bookings()
    {
        return $this->hasMany('App\room_booking','member_id')->whereNull('customer_id')->whereNotNull('member_id');
    }
    public function receipts()
    {
        return $this->hasMany('App\room_payment_receipt','mem_number')->whereNull('customer_id')->whereNotNull('mem_number');
    }

     public function invoices()
    {
        return $this->hasMany('App\finance_invoice','member_id')->whereNull('customer_id')->whereNotNull('member_id');
    }

    public function getCurAddressAttribute($value)
    {
        if($value==''){
            return 'n/a';
        }
        return $value;
    } public function getMobAAttribute($value)
    {
        if($value==''){
            return 'n/a';
        }
        return $value;
    }

    public function cars()
    {
        return $this->hasOne('App\mem_car','member_id');
    }
    public function  family(){
        return $this->hasMany('App\corporateMemFamily','member_id');
    }
   
    
    public function bookingDocs(){
        return $this->hasMany('App\media','type_id')->where('type',12);
    }
    public function visits(){
        return $this->hasMany('App\mem_visits','type_id')->where('type',11);
    }
    public function subscriptions(){
        return $this->hasMany('App\memberSubscriptions','member_id');

    }
    public function eventDocs(){
        return $this->hasMany('App\media','type_id')->where('type',62);
    }

     public function generalVoucherDocs(){
        return $this->hasMany('App\media','type_id')->where('type',82);
    }
   public function transactions(){
        return $this->hasMany('App\transactions','trans_moc')->where('trans_moc_type',6);
    }
    public function member_status(){
        return $this->belongsTo('App\mem_status','active');

    } public function member_classification(){
        return $this->belongsTo('App\mem_classification','mem_classification_id');

    }

 public function CakeBookingDocs(){
        return $this->hasMany('App\media','type_id')->where('type',100);
    }

 public function profilePic(){
        return $this->hasOne('App\media','trans_type_id')->where('trans_type',33);
    }
     public function docs(){
        return $this->hasMany('App\media','trans_type_id')->where('trans_type',180);
    }
}
