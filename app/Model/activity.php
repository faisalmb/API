<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class activity extends Model
{
    protected $fillable =['id', 'name', 'ename', 'info', 'IsActive', 'created_at', 'updated_at'];
}
