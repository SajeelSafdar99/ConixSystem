<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\event_bookingsub;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class event_booking extends Model
{
    use SoftDeletes;
    use Userstamps;
    protected $fillable = ['id','booking_no','booking_date','family', 'booked_by', 'booking_type', 'moc_name', 'customer_id', 'member_id', 'moc_address', 'moc_cnic',  'moc_mob',  'moc_email', 'nature_of_event', 'event_date', 'from', 'to','venue', 'menu', 'menu_category', 'menu_charges', 'total_addon_charges', 'total_per_person_charges', 'guests', 'total_food_charges', 'extra_guests', 'extra_food_charges','grand_guest_charges', 'total_other_charges','total_charges', 'discount_amount', 'discount_details', 'grand_total', 'payment_mode', 'payment_mode_details', 'advance_paid', 'total_balance', 'booking_docs', 'additional_notes', 'amount_paid', 'grand_balance','check_out_status','ledger_amount', 'deleted_at', 'discount_percentage', 'amount_in_words', 'surcharge', 'surcharge_percentage', 'surcharge_details', 'surcharge_total', 'cancel_details', 'deleted_at', 'created_by', 'updated_by', 'deleted_by', 'coa_code'];

     public function customer(){

        return $this->belongsTo('App\customer');
    }  public function member(){

    return $this->belongsTo('App\membership','member_id');
}
 public function eventBookings(){

    	return $this->hasMany('App\event_bookingsub','booking_id','id');
    }

    public function eventAddOns(){

    	return $this->hasMany('App\event_bookingaddonsub','booking_id','id');
    }

     public function menus(){

        return $this->hasMany('App\event_bookingmenusub','booking_id','id');
    }


     public function eventDocs(){
        return $this->hasMany('App\media','trans_type_id')->where('trans_type',2);
    }

}
