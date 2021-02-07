<?php

namespace App\Model;

use App\Model\BaseModel;


class branchPhone extends BaseModel
{
    protected $fillable = ['id', 'phone', 'type', 'branch_id', 'IsActive', 'created_at', 'updated_at'];
   
}
