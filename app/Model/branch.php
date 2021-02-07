<?php

namespace App\Model;

use App\Model\BaseModel;


class branch extends BaseModel
{
    protected $fillable = ['id', 'user_id', 'company_id', 'name', 'location', 
    'type', 'IsActive', 'created_at', 'updated_at'];
   
}
