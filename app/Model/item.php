<?php

namespace App\Model;

use App\Model\BaseModel;


class item extends BaseModel
{
    protected $fillable =['id', 'company_id', 'category_id', 'name', 'ename', 'commercial_name'
    , 'supplier', 'info', 'created_at', 'updated_at'];

}
