<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class role extends Model
{
    protected $fillable =['id', 'name', 'short_name', 'description', 'code','IsActive', 'created_at', 'updated_at'];
}
