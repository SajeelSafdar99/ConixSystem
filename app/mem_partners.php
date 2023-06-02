<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class mem_partners extends Model
{
	use SoftDeletes;
	use Userstamps;
    protected $fillable = ['type','partner_name', 'facilitation', 'address', 'partner_mob_a', 'partner_mob_b', 'partner_tel_a', 'partner_email', 'website', 'focal_person_name', 'focal_mob_a', 'focal_mob_b', 'focal_tel_a', 'focal_email', 'documents', 'status', 'deleted_at','created_by','updated_by','deleted_by', 'remarks', 'agreement_date'];

    public function partnerDocs(){
        return $this->hasMany('App\media','type_id')->where('type',90);
    }

}
