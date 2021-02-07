<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;


class city extends Model
{
    protected $fillable =['id', 'state_id', 'name', 'ename', 'info', 'IsActive', 'created_at', 'updated_at'];
  
}
