<?php
namespace App\Traits;

use App\Model\city;
use App\Traits\Statefunction;

trait Cityfunction
{
    use Genralfunction;
    use Statefunction;

    // get city by id
    public function cityById($id)
    {
        $city = city::where('id',$id)
        ->first();

        if ($city) {
            $stateId = $city->state_id;
            $state = $this->stateById($stateId)->original['data'];
            $responseObj = (object) array(
                'country' =>$state->country ,
                'state' =>$state->state,
                'city' =>$city);
            return $this->generalResponse(true,200,'success', null,$responseObj);
        } else {
            return $this->generalResponse(false,404,'city not found', null,null);
        }
    }

    // add city function
    public function addcity($name, $ename, $stateId, $info)
    {
        $state = $this->stateById($stateId)->original['status'];
       
        if ($state) {

            $city = city::select('*')
            ->where('state_id',$stateId)
            ->where('name',$name)
            ->orWhere('ename',$ename)
            ->first();
            if (!$city) {
    
                $creat = city::create(['name'=>$name,'ename'=>$ename,'state_id'=>$stateId
                ,'info'=>$info])->id;
            
                if ($creat) {
                
                    return $this->generalResponse(true,200,'success', null,$this->cityById($creat)->original['data']);
            
                }
            
            } else {
                
                $msg = 'city exist';
                return $this->generalResponse(false, 409,$msg, null,null);
            
            }

        } else {
            return $this->stateById($stateId);
        }
        
      
    }


    // update cuntry function
    public function updatecity($id,$name, $ename, $stateId, $info,$IsActive)
    {
        $state = $this->stateById($stateId)->original['status'];
       
        if ($state) {
            $cityExist = $this->cityById($id)->original['status'];
            if ($cityExist) {

                $city = city::select('*')
                ->where('state_id',$stateId)
                ->where('name',$name)
                ->orWhere('ename',$ename)
                ->first();

                if (!$city) {

                    return $this->exeUpdatecity($id,$name, $ename, $stateId, $info,$IsActive);
                
                } else {

                    if ($city->id == $id) {
                        return $this->exeUpdatecity($id,$name, $ename, $stateId, $info,$IsActive);
                    } else {
                        $msg = 'city exist';
                    return $this->generalResponse(false, 409,$msg, null,null);
                    }
                
                }

            } else {
               return $this->cityById($id);
            }
            
           

        } else {
            return $this->stateById($stateId);
        }
    }

   // execute update city function
   private function exeUpdatecity($id,$name, $ename, $stateId, $info,$IsActive)
   {
        $creat = city::where('id',$id)->update(['name'=>$name,'ename'=>$ename,'state_id'=>$stateId
        ,'info'=>$info,'IsActive'=>$IsActive]);
        if ($creat) {
            return $this->generalResponse(true,200,'success', null,$this->cityById($id)->original['data']);
        } else {
            $msg = 'city not found';
            return $this->generalResponse(false, 404,$msg, null,null);
        }
   }

   // get city in state by page 
   public function citiesByPage($stateId,$page)
   {
       $page=$page*20;
       $city = city::select('*')
       ->where('state_id',$stateId)
       ->skip($page)
       ->take(20)
       ->get();
      
   
       $response = $this->generalResponse(true,200,'success', null,$city);
   
       if (count($city) == 0) {
        $response = $this->generalResponse(false,404,'city not found', null,null);
       }

       return $response;
   }

    // get city in state by info and Page
    public function citiesByInfoAndPage($page,$stateId,$search)
    {
        $page=$page*20;
        $city = city::where('state_id',$stateId)
        ->where(function($q) use ($search) {
            $q->where('name','LIKE',"%".str_ireplace("%20"," ", $search)."%")
              ->orWhere('ename','LIKE',"%".str_ireplace("%20"," ", $search)."%");
              })
        ->skip($page)
        ->take(20)
        ->get();
    
        $response = $this->generalResponse(true,200,'success', null,$city);
    
        if (count($city) == 0) {
        $response = $this->generalResponse(false,404,'city not found', null,null);
        }

        return $response;
    }
}