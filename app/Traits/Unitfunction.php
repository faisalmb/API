<?php
namespace App\Traits;

use App\Model\unit;
use App\Model\unitCategory;
use App\Traits\Genralfunction;

trait Unitfunction
{
    use Genralfunction;


/* unit category section */

    // get category by id
    public function categoryById($id)
    {
        $unitCategory = unitCategory::where('id',$id)
        ->first();

        if ($unitCategory) {
            return $this->generalResponse(true,200,'success', null,$unitCategory);
        } else {
            return $this->generalResponse(false,404,'not found', null,null);
        }
    }


    public function categoryByPage($page)
    {
        $page = $page *10;
        $unitCategory = unitCategory::skip($page)
        ->take(10)
        ->get();

        if ($unitCategory && count($unitCategory)>0) {
            return $this->generalResponse(true,200,'success', null,$unitCategory);
        } else {
            return $this->generalResponse(false,404,'not found', null,null);
        }
    }


    public function categoryByPageAndInfo($search,$page)
    {
        $page = $page *10;
        $unitCategory = unitCategory::where(function($q) use ($search) {
            $q->where('name','LIKE',"%".str_ireplace("%20"," ", $search)."%")
              ->orWhere('ename','LIKE',"%".str_ireplace("%20"," ", $search)."%");
              })
        ->skip($page)
        ->take(10)
        ->get();

        if ($unitCategory && count($unitCategory)>0) {
            return $this->generalResponse(true,200,'success', null,$unitCategory);
        } else {
            return $this->generalResponse(false,404,'not found', null,null);
        }
    }

    // add list of category for unit by sys admin
    public function addUnitCategoryList($name, $ename, $info)
    {
       $unitCategory = unitCategory::select('*')
       ->where('name',$name)
       ->orWhere('ename',$ename)
       ->first();
       if (!$unitCategory) {

            $creat = unitCategory::create(['name'=>$name,'ename'=>$ename,'info'=>$info])->id;
        
            if ($creat) {
            
                return (object) array('status' =>'sucsess' ,
                 'data' =>['name'=>$name,'ename'=>$ename,'info'=>$info] );
        
            }
       
        } else {
            
            return (object) array('status' =>'Failure' ,
            'data' =>['name'=>$name,'ename'=>$ename,'info'=>$info] );
        
        }
       
    }


    // add category for unit by sys admin
    public function addUnitCategory($name, $ename, $info)
    {
        $unitCategory = unitCategory::where('name',$name)
        ->orWhere('ename',$ename)
        ->first();
        if (!$unitCategory) {

            $creat = unitCategory::create(['name'=>$name,'ename'=>$ename,'info'=>$info])->id;
        
            if ($creat) {
            
                return $this->generalResponse(true, 200,'success', null,$this->categoryById($creat)->original['data']);
        
            }
        
        } else {
            
            $msg = 'category exist';
            return $this->generalResponse(false, 409,$msg, null,null);
        
        }
        
    }



    // update category  by sys admin
    public function updateUnitCategory($id,$name, $ename, $info)
    {
        if ($this->categoryById($id)->original['code'] == 200) {
            $unitCategory = unitCategory::select('*')
            ->where('name',$name)
            ->orWhere('ename',$ename)
            ->first();
        
            if (!$unitCategory || $unitCategory->id == $id) {
            
                $update = unitCategory::where('id',$id)->update(['name'=>$name,'ename'=>$ename,'info'=>$info]);
            
                if ($update) {
            
                    return $this->generalResponse(true, 200,'success', null,$this->categoryById($id)->original['data']);
            
                }else {
                    return $update;
                }
        
            } else {
            
                $msg = 'category exist';
                return $this->generalResponse(false, 409,$msg, null,null);
        
            }

        } else {
            return $this->categoryById($id);
        }
        
        
    
    }
 /* end unit category section */

//  ----------------------------------------------------------------------

/* unit section */

    // get unit by id
    public function unitById($id)
    {
        $unit = unit::where('id',$id)
        ->first();

        if ($unit) {
            return $this->generalResponse(true,200,'success', null,$unit);
        } else {
            return $this->generalResponse(false,404,'not found', null,null);
        }
    }


    public function unitByPage($page)
    {
        $page = $page *10;
        $unit = unit::skip($page)
        ->take(10)
        ->get();

        if ($unit && count($unit)>0) {
            return $this->generalResponse(true,200,'success', null,$unit);
        } else {
            return $this->generalResponse(false,404,'not found', null,null);
        }
    }

    public function unitByCategoryIdAndPage($categoryId,$page)
    {
        $page = $page *10;
        $unit = unit::where('category_id',$categoryId)
        ->skip($page)
        ->take(10)
        ->get();

        if ($unit && count($unit)>0) {
            return $this->generalResponse(true,200,'success', null,$unit);
        } else {
            return $this->generalResponse(false,404,'not found', null,null);
        }
    }


    public function unitByPageAndInfo($search,$page)
    {
        $page = $page *10;
        $unit = unit::where(function($q) use ($search) {
            $q->where('name','LIKE',"%".str_ireplace("%20"," ", $search)."%")
              ->orWhere('ename','LIKE',"%".str_ireplace("%20"," ", $search)."%");
              })
        ->skip($page)
        ->take(10)
        ->get();

        if ($unit && count($unit)>0) {
            return $this->generalResponse(true,200,'success', null,$unit);
        } else {
            return $this->generalResponse(false,404,'not found', null,null);
        }
    }



    public function unitByPageAndInfoAndCategoryId($categoryId,$search,$page)
    {
        $page = $page *10;
        $unit = unit::where('category_id',$categoryId)
        ->where(function($q) use ($search) {
            $q->where('name','LIKE',"%".str_ireplace("%20"," ", $search)."%")
              ->orWhere('ename','LIKE',"%".str_ireplace("%20"," ", $search)."%");
              })
        ->skip($page)
        ->take(10)
        ->get();

        if ($unit && count($unit)>0) {
            return $this->generalResponse(true,200,'success', null,$unit);
        } else {
            return $this->generalResponse(false,404,'not found', null,null);
        }
    }

    // add list of unit  by sys admin
    public function addUnitList($categoryId,$name, $ename, $info)
    {
       $unit = unit::select('*')
       ->where('category_id',$categoryId)
       ->where('name',$name)
       ->orWhere('ename',$ename)
       ->first();
       if (!$unit) {

            $creat = unit::create(['category_id'=>$categoryId,'name'=>$name,'ename'=>$ename,'info'=>$info])->id;
        
            if ($creat) {
            
                return (object) array('status' =>'sucsess' ,
                 'data' =>['name'=>$name,'ename'=>$ename,'info'=>$info] );
        
            }
       
        } else {
            
            return (object) array('status' =>'Failure' ,
            'data' =>['name'=>$name,'ename'=>$ename,'info'=>$info] );
        
        }
       
    }


    // add unit  by sys admin
    public function addUnit($categoryId,$name, $ename, $info)
    {
        $unit = unit::where('category_id',$categoryId)
        ->where('name',$name)
        ->orWhere('ename',$ename)
        ->first();
        if (!$unit) {

            $creat = unit::create(['category_id'=>$categoryId,'name'=>$name,'ename'=>$ename,'info'=>$info])->id;
        
            if ($creat) {
            
                return $this->generalResponse(true, 200,'success', null,$this->unitById($creat)->original['data']);
        
            }
        
        } else {
            
            $msg = 'unit exist';
            return $this->generalResponse(false, 409,$msg, null,null);
        
        }
        
    }



    // update unit  by sys admin
    public function updateUnit($id,$categoryId,$name, $ename, $info)
    {
        if ($this->unitById($id)->original['code'] == 200) {
            $unit = unit::select('*')
            ->where('category_id',$categoryId)
            ->where('name',$name)
            ->orWhere('ename',$ename)
            ->first();
        
            if (!$unit || $unit->id == $id) {
            
                $update = unit::where('id',$id)->update(['category_id'=>$categoryId,'name'=>$name,'ename'=>$ename,'info'=>$info]);
            
                if ($update) {
            
                    return $this->generalResponse(true, 200,'success', null,$this->unitById($id)->original['data']);
            
                }else {
                    return $update;
                }
        
            } else {
            
                $msg = 'unit exist';
                return $this->generalResponse(false, 409,$msg, null,null);
        
            }

        } else {
            return $this->unitById($id);
        }
        
        
    
    }
 /* end unit section */


}