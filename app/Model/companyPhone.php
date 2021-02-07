<?php

namespace App\Model;

use App\Model\BaseModel;

class companyPhone extends BaseModel
{
    protected $fillable =['id', 'phone', 'type', 'company_id', 'IsActive', 'created_at', 'updated_at'];
 
}
