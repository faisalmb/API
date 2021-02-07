<?php
namespace App\Traits;


use App\Model\state;
use App\Traits\Genralfunction;

trait Statefunction
{
    use Genralfunction;
    use Countryfunction;

    // get state by id
    public function stateById($id)
    {
        $state = state::select('*')
        ->where('id',$id)
        ->first();

        

        if ($state) {
            $countryId = $state->country_id;
            $country = $this->countryById($countryId)->original['data'];
            $responseObj = (object) array(
                'country' =>$country ,
                'state' =>$state );
            return $this->generalResponse(true,200,'success', null,$responseObj);
        } else {
            return $this->generalResponse(false,404,'state not found', null,null);
        }
    }

    // add state function
    public function addstate($name, $ename, $countryId, $info)
    {
        $country = $this->countryById($countryId)->original['status'];

        if ($country) {

            $state = state::select('*')
            ->where('country_id',$countryId)
            ->where('name',$name)
            ->orWhere('ename',$ename)
            ->first();
            if (!$state) {
    
                $creat = state::create(['name'=>$name,'ename'=>$ename,'country_id'=>$countryId
                ,'info'=>$info])->id;
            
                if ($creat) {
                
                    return $this->generalResponse(true,200,'success', null,$this->stateById($creat)->original['data']);
            
                }
            
            } else {
                
                $msg = 'state exist';
                return $this->generalResponse(false, 409,$msg, null,null);
            
            }

        } else {
            return $this->countryById($countryId);
        }


    }


    // update cuntry function
    public function updatestate($id,$name, $ename, $countryId, $info,$IsActive)
    {
        $country = $this->countryById($countryId)->original['status'];

        if ($country) {

            $state = state::select('*')
            ->where('country_id',$countryId)
            ->where('name',$name)
            ->orWhere('ename',$ename)
            ->first();

            if (!$state) {

                return $this->exeUpdatestate($id,$name, $ename, $countryId, $info,$IsActive);
            
            } else {

                if ($state->id == $id) {
                    return $this->exeUpdatestate($id,$name, $ename, $countryId, $info,$IsActive);
                } else {
                    $msg = 'state exist';
                return $this->generalResponse(false, 409,$msg, null,null);
                }
            
            }

        } else {
            return $this->countryById($countryId);
        }
        

        
    }

   // execute update state function
   private function exeUpdatestate($id,$name, $ename, $countryId, $info,$IsActive)
   {
        $creat = state::where('id',$id)->update(['name'=>$name,'ename'=>$ename,'country_id'=>$countryId
        ,'info'=>$info,'IsActive'=>$IsActive]);
        if ($creat) {
            return $this->generalResponse(true,200,'success', null,$this->stateById($id)->original['data']);
        } else {
            $msg = 'Cannot update state';
            return $this->generalResponse(false, 404,$msg, null,null);
        }
   }

   // get state in country by page 
   public function statesByPage($countryId,$page)
   {
       $page=$page*20;
       $state = state::select('*')
       ->where('country_id',$countryId)
       ->skip($page)
       ->take(20)
       ->get();
      
   
       $response = $this->generalResponse(true,200,'success', null,$state);
   
       if (count($state) == 0) {
        $response = $this->generalResponse(false,404,'state not found', null,null);
       }

       return $response;
   }

    // get state in country by info and Page
    public function statesByInfoAndPage($page,$countryId,$search)
    {
        $page=$page*20;
        $state = state::select('*')
        ->where('country_id',$countryId)
        ->where(function($q) use ($search) {
            $q->where('name','LIKE',"%".str_ireplace("%20"," ", $search)."%")
              ->orWhere('ename','LIKE',"%".str_ireplace("%20"," ", $search)."%");
              })
        ->skip($page)
        ->take(20)
        ->get();
    
        $response = $this->generalResponse(true,200,'success', null,$state);
    
        if (count($state) == 0) {
            $response = $this->generalResponse(false,404,'state not found', null,null);
         }

        return $response;
    }
}