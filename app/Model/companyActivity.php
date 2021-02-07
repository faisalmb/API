<?php

namespace App\Model;

use App\Model\BaseModel;

class companyActivity extends BaseModel
{
    protected $fillable =['id', 'activity_id', 'company_id', 'IsActive', 'created_at', 'updated_at'];
}

