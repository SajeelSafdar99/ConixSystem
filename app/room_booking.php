<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\room_category_charges;
use App\bookingsub;
use App\room_check_in;
use App\room_check_out;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;
class room_booking extends Model
{
    use SoftDeletes;
    use Userstamps;
    protected $fillable = ['id','booking_no','booking_date', 'check_in_date', 'arrival_details', 'check_out_date', 'departure_details', 'first_name', 'last_name', 'guest_company', 'guest_address', 'guest_country', 'guest_city', 'guest_mob', 'guest_email', 'guest_cnic', 'accompained_guest', 'acc_relationship', 'acc_cnic','family', 'booked_by', 'booking_type', 'moc_name', 'customer_id', 'member_id', 'moc_address', 'moc_cnic',  'moc_mob',  'moc_email', 'room', 'category', 'pday_charges_id', 'nights', 'charges', 'security', 'total_room_charges', 'total_charges', 'discount_amount', 'discount_details', 'grand_total', 'payment_mode', 'payment_mode_details', 'advance_paid', 'total_balance', 'booking_docs', 'additional_notes', 'check_out_time', 'amount_paid', 'grand_balance','check_inn_date','check_in_time','check_out_status','status', 'deleted_at', 'ledger_amount', 'created_by', 'updated_by', 'deleted_by','food_bill_charges', 'coa_code', 'corporate_id'];

       public function categorywithchanges(){

    	return $this->hasMany('App\room_category_charges','pday_charges_id','id');
    }

    public function numberwithtype(){

    	return $this->hasMany('App\room_category_charges','rooms_id','id');
    }

    public function bookings(){

    	return $this->hasMany('App\bookingsub','booking_id','id');
    }

    public function media(){
        return $this->hasMany('App\media','moc_id','id')->where('m_or_c',2);

    }

 public function checkinstatus(){

        return $this->hasOne('App\room_check_in','booking_id','id');
    }

    public function checkout(){

        return $this->hasMany('App\room_check_out','booking_id','id');
    }
    public function customer(){

        return $this->belongsTo('App\customer');
    }  public function member(){

    return $this->belongsTo('App\membership','member_id');
}

 public function corporateMember(){

    return $this->belongsTo('App\corporateMembership','corporate_id');
}


public  function invoices(){
           return $this->hasOne('App\transactions','trans_type_id','id')->where('debit_or_credit',1)->where('trans_type',1)->where('type',1);

}public  function receipts(){
           return $this->hasOne('App\transactions','trans_type_id','id')->where('debit_or_credit',0)->where('trans_type',1)->where('type',2);

}

 public function bookingDocs(){
        return $this->hasMany('App\media','trans_type_id')->where('trans_type',1);
    }


}
