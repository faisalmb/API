<?php

namespace App\Model;

use App\Model\BaseModel;


class branchUser extends BaseModel
{
    protected $fillable = ['id', 'user_id', 'branch_id', 'IsActive', 'IsAdmin', 'created_at', 'updated_at'];
   
}
