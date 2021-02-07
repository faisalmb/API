<?php

namespace App\Model;

use App\Model\BaseModel;


class branchUserRole extends BaseModel
{
    protected $fillable = ['id', 'branch_user_id', 'role_id', 'created_at', 'updated_at'];
   
}
