<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class customer extends Model
{
 
    protected $fillable =  ['id', 'phone','user_id'];
    
}
