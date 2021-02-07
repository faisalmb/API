<?php

namespace App\Model;

use App\Model\BaseModel;

class user extends BaseModel
{
   
    protected $fillable =['id', 'fullname', 'phone', 'email', 'password', 'recover', 'token', 
    'IsActive', 'IsSuperAdmin','IsConfirmedPhone', 'IsConfirmedEmaile', 'country_id', 'otp', 'created_at', 'updated_at'];
  
}
