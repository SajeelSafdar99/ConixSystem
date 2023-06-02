<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class mem_address extends Model
{
    protected $fillable = ['member_id','address_type','address', 'city', 'country','make_primary'];
}
