<?php

namespace App\Model;

use App\Model\BaseModel;


class linkingStokWithConversion extends BaseModel
{
    protected $fillable =['id', 'stock_id', 'conversions_id', 'created_at', 'updated_at'];

 
}



