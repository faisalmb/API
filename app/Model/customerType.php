<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class customerType extends Model
{
    protected $fillable =['id', 'name', 'ename', 'tag', 'created_at', 'updated_at'];
}
