<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class unit extends Model
{
    protected $fillable =['id', 'category_id', 'name', 'ename', 'info', 'created_at', 'updated_at'];
}
