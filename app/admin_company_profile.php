<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Wildside\Userstamps\Userstamps;

class admin_company_profile extends Model
{

	use Userstamps;
    protected $fillable = ['company_logo','company_name','company_address','company_city','company_number','company_email', 'company_website', 'created_by', 'updated_by', 'organization_name', 'cost_center'];
}
