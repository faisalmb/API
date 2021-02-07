<?php

namespace App\Model;

use App\Model\BaseModel;

class company extends BaseModel
{
    protected $fillable = ['id', 'name', 'country_id', 'state_id', 'city_id', 'address', 'tax_number', 'user_id', 
    'IsActive', 'IsOfficial', 'created_at', 'updated_at'];
}
