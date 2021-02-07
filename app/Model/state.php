<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class state extends Model
{
    protected $fillable =['id', 'country_id', 'name', 'ename', 'info', 'IsActive', 'created_at', 'updated_at'];
}
