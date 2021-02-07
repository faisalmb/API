<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class country extends Model
{
    protected $fillable =['id', 'name', 'ename', 'code', 'phoneCode', 'IsActive', 'created_at', 'updated_at'];
}
