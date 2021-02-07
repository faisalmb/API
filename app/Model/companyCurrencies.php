<?php

namespace App\Model;

use App\Model\BaseModel;


class companyCurrencies extends BaseModel
{
    protected $fillable =['id', 'currency_id', 'company_id','IsActive', 'created_at', 'updated_at'];
  
}
