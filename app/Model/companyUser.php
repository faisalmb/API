<?php

namespace App\Model;

use App\Model\BaseModel;
use Webpatser\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;

class companyUser extends BaseModel
{
    protected $fillable =['id', 'user_id', 'company_id', 'IsActive', 'IsAdmin', 'created_at', 'updated_at'];
   

}
