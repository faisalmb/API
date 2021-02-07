<?php

namespace App\Model;

use App\Model\BaseModel;

class stock extends BaseModel
{
    protected $fillable =['id', 'branch_id', 'item_id', 'quantity', 'basic_unit_id','conversions_id',
     'price', 'created_at', 'updated_at'];
     
  
}
