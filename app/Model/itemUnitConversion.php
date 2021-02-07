<?php

namespace App\Model;

use App\Model\BaseModel;

class itemUnitConversion extends BaseModel
{
    protected $fillable =['id', 'item_id', 'base_unit_id', 'multiplier', 'to_unit_id', 'created_at', 'updated_at'];

}
