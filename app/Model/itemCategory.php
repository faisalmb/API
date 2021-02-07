<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class itemCategory extends Model
{
    protected $fillable =['id', 'company_id', 'name', 'ename', 'info', 'created_at', 'updated_at'];
}
