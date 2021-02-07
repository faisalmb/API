<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class currency extends Model
{
    protected $fillable =['id', 'name', 'shortname', 'country', 'created_at', 'updated_at'];
}
