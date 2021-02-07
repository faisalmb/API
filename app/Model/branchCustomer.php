<?php

namespace App\Model;

use App\Model\BaseModel;

class branchCustomer extends BaseModel
{

    protected $fillable =  ['id', 'branch_id', 'type_id', 'customer_id', 'phone', 'name', 'IsActive', 'created_at', 'updated_at'];

}
