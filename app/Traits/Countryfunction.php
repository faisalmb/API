<?php
namespace App\Traits;

use App\Model\country;
use App\Traits\Genralfunction;

trait Countryfunction
{
    use Genralfunction;

    // get country by id
    public function countryById($id)
    {
        $country = country::select('*')
        ->where('id',$id)
        ->first();

        if ($country) {
            return $this->generalResponse(true,200,'success', null,$country);
        } else {
            return $this->generalResponse(false,404,'country not found', null,null);
        }
    }

    // add country function
    public function addCountry($name, $ename, $code, $phoneCode)
    {
        $country = country::select('*')
        ->where('name',$name)
        ->orWhere('ename',$ename)
        ->first();
        if (!$country) {

            $creat = country::create(['name'=>$name,'ename'=>$ename,'code'=>$code
            ,'phoneCode'=>$phoneCode])->id;
        
            if ($creat) {
            
                return $this->generalResponse(true,200,'success', null,$this->countryById($creat)->original['data']);
        
            }
        
        } else {
            
            $msg = 'country exist';
            return $this->generalResponse(false, 409,$msg, null,null);
        
        }
    }


    // update cuntry function
    public function updateCountry($id,$name, $ename, $code, $phoneCode,$IsActive)
    {
        $country = country::select('*')
        ->where('name',$name)
        ->orWhere('ename',$ename)
        ->orWhere('code',$code)
        ->orWhere('phoneCode',$phoneCode)
        ->first();

        if (!$country) {

            return $this->exeUpdateCountry($id,$name, $ename, $code, $phoneCode,$IsActive);
        
        } else {

            if ($country->id == $id) {
                return $this->exeUpdateCountry($id,$name, $ename, $code, $phoneCode,$IsActive);
            } else {
                $msg = 'country exist';
            return $this->generalResponse(false, 409,$msg, null,null);
            }
        
        }
    }

   // execute update country function
   private function exeUpdateCountry($id,$name, $ename, $code, $phoneCode,$IsActive)
   {
        $creat = country::where('id',$id)->update(['name'=>$name,'ename'=>$ename,'code'=>$code
        ,'phoneCode'=>$phoneCode,'IsActive'=>$IsActive]);
        if ($creat) {
            return $this->generalResponse(true,200,'success', null,$this->countryById($id)->original['data']);
        } else {
            $msg = 'Cannot create country';
            return $this->generalResponse(false, 500,$msg, null,null);
        }
   }

   // get country by page
   public function countriesByPage($page)
   {
       $page=$page*20;
       $country = country::select('*')
       ->skip($page)
       ->take(20)
       ->get();
      
   
       $response = $this->generalResponse(true,200,'success', null,$country);
   
       if (count($country) == 0) {
        $response = $this->generalResponse(false,404,'country not found', null,null);
       }

       return $response;
   }

    // get country by info and Page
    public function countriesByInfoAndPage($page,$search)
    {
        $page=$page*20;
        $country = country::select('*')
        ->where(function($q) use ($search) {
            $q->where('name','LIKE',"%".str_ireplace("%20"," ", $search)."%")
              ->orWhere('ename','LIKE',"%".str_ireplace("%20"," ", $search)."%")
              ->orWhere('code','LIKE',"%".str_ireplace("%20"," ", $search)."%")
              ->orWhere('phoneCode','LIKE',"%".str_ireplace("%20"," ", $search)."%");
              })
        ->skip($page)
        ->take(20)
        ->get();
    
        $response = $this->generalResponse(true,200,'success', null,$country);
    
        if (count($country) == 0) {
        $response = $this->generalResponse(false,404,'country not found', null,null);
        }

        return $response;
    }
}