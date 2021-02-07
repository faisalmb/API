<?php

namespace App\Model;

use App\Model\BaseModel;


class accountSubGroup extends BaseModel
{
    protected $fillable =  ['id', 'branch_id', 'parent_id', 'master_id', 'name',
     'ename', 'tag', 'code', 'created_at', 'updated_at'];
 
}
