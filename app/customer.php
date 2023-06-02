<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class customer extends Model
{
use Userstamps;
	use SoftDeletes;
    protected $fillable = ['customer_no','customer_name','customer_address','customer_cnic','customer_contact','customer_email', 'deleted_at', 'member_name', 'mem_no', 'created_by', 'updated_by', 'deleted_by', 'guest_type', 'account', 'affiliate'];


     public function getTableColumns() {
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    }


    public function bookings()
    {
        return $this->hasMany('App\room_booking','customer_id')->whereNull('member_id')->whereNotNull('customer_id');
    }
    public function receipts()
    {
        return $this->hasMany('App\room_payment_receipt','customer_id')->whereNull('mem_number')->whereNotNull('customer_id');
    }

     public function invoices()
    {
        return $this->hasMany('App\finance_invoice','customer_id')->whereNull('member_id')->whereNotNull('customer_id');
    }

    public function docs(){
        return $this->hasMany('App\media','type_id')->where('type',0);
    }
    public function profilePic(){
        return $this->hasOne('App\media','type_id')->where('type',1);
    }
    public function bookingDocs(){
        return $this->hasMany('App\media','type_id')->where('type',2);
    }

    public function eventDocs(){
        return $this->hasMany('App\media','type_id')->where('type',61);
    }

    public function generalVoucherDocs(){
        return $this->hasMany('App\media','type_id')->where('type',81);
    }
    public function transactions(){
        return $this->hasMany('App\transactions','trans_moc')->where('trans_moc_type',1);
    }

     public function CakeBookingDocs(){
        return $this->hasMany('App\media','type_id')->where('type',101);
    }
}
