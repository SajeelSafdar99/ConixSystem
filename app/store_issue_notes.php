<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class store_issue_notes extends Model
{
	use SoftDeletes;
	use Userstamps;
    protected $fillable = ['invoice_date','store_location','department', 'gross', 'discount','tax','additional_charges', 'grand_total', 'remarks', 'approved', 'amount_in_words','deleted_at', 'created_by', 'updated_by', 'deleted_by', 'unit'];

     public function issuenotesubs(){

    	return $this->hasMany('App\store_issue_notes_subs','issue_id','id');
    }
   
}
