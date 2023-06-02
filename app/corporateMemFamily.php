<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class corporateMemFamily extends Model
{
    use SoftDeletes;

use Userstamps;
    protected $fillable = ['member_id', 'member_name', 'membership_number', 'next_of_kin','relationship', 'name', 'date_of_birth', 'fam_relationship', 'nationality', 'cnic', 'contact', 'maritial_status', 'fam_picture', 'sup_card_no', 'card_status', 'sup_card_issue', 'sup_card_exp', 'sup_barcode', 'status', 'deleted_at', 'remarks', 'passport_no','created_by', 'updated_by', 'deleted_by','title', 'first_name', 'middle_name', 'name_comment', 'gender'];


    public function getTableColumns() {
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    }

/*public function familymemberPic(){
        return $this->hasOne('App\media','type_id')->where('type',20);
    }*/
     public function familymemberPic(){
        return $this->hasOne('App\media','trans_type_id')->where('trans_type',200);
    }
   
/*
    public function images(){
        return $this->hasMany('App\media','type_id','id')->where('type',20);

    }*/
    public function relationship_name(){
        return $this->hasOne('App\mem_relation','id','fam_relationship');

    }

    public function status_name(){
        return $this->hasOne('App\mem_status','id','status');

    }


    public function visits(){
        return $this->hasMany('App\mem_visits','type_id')->where('type',20);
    }


}
