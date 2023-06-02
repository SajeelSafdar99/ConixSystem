<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class finance_invoice_subs extends Model
{
	use SoftDeletes;
	use Userstamps;
    protected  $fillable=['created_at','updated_at','start_date','end_date', 'deleted_at', 'deleted_by', 'family', 'invoice_id', 'start_date', 'end_date', 'days', 'qty', 'sub_total', 'charges_amount', 'charges_type_id', 'charges_type'];
    public function subscription(){
        return $this->belongsTo('App\sports_subscription','charges_type_id','id');
    }
}
