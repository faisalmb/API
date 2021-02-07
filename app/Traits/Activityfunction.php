<?php
namespace App\Traits;
use App\Model\activity;
use App\Model\companyActivity;
use App\Traits\Genralfunction;

trait Activityfunction
{
    use Genralfunction;

    // get activity by id
    public function activityById($id)
    {
        $activity = activity::where('id',$id)
        ->first();

        if ($activity) {
            return $this->generalResponse(true,200,'success', null,$activity);
        } else {
            return $this->generalResponse(false,404,'activity not found', null,null);
        }
    }

    // add activity function
    public function addActivity($name, $ename, $info)
    {
        $activity = activity::where('name',$name)
        ->orWhere('ename',$ename)
        ->first();
        if (!$activity) {

            $creat = activity::create(['name'=>$name,'ename'=>$ename,'info'=>$info])->id;
        
            if ($creat) {
            
                return $this->generalResponse(true,200,'success', null,$this->activityById($creat)->original['data']);
        
            }
        
        } else {
            
            $msg = 'activity exist';
            return $this->generalResponse(false, 409,$msg, null,null);
        
        }
    }


    // update cuntry function
    public function updateActivity($id,$name, $ename, $info,$IsActive)
    {
        $activity = activity::where('name',$name)
        ->orWhere('ename',$ename)
        ->first();

        if (!$activity) {

            return $this->exeUpdateActivity($id,$name, $ename, $info,$IsActive);
        
        } else {

            if ($activity->id == $id) {
                return $this->exeUpdateActivity($id,$name, $ename, $info,$IsActive);
            } else {
                $msg = 'activity exist';
            return $this->generalResponse(false, 409,$msg, null,null);
            }
        
        }
    }

   // execute update activity function
   private function exeUpdateActivity($id,$name, $ename, $info,$IsActive)
   {
        $creat = activity::where('id',$id)->update(['name'=>$name,'ename'=>$ename,'info'=>$info
        ,'IsActive'=>$IsActive]);
        if ($creat) {
            return $this->generalResponse(true,200,'success', null,$this->activityById($id)->original['data']);
        } else {
            $msg = 'Cannot create activity';
            return $this->generalResponse(false, 500,$msg, null,null);
        }
   }

   // get activity by page
   public function activitiesByPage($page)
   {
       $page=$page*20;
       $activity = activity::select('*')
       ->skip($page)
       ->take(20)
       ->get();
      
   
       $response = $this->generalResponse(true,200,'success', null,$activity);
   
       if (count($activity) == 0) {
        $response = $this->generalResponse(false,404,'activity not found', null,null);
       }

       return $response;
   }

    // get activity by info and Page
    public function activitiesByInfoAndPage($page,$search)
    {
        $page=$page*20;
        $activity = activity::where(function($q) use ($search) {
            $q->where('name','LIKE',"%".str_ireplace("%20"," ", $search)."%")
              ->orWhere('ename','LIKE',"%".str_ireplace("%20"," ", $search)."%");
              })
        ->skip($page)
        ->take(20)
        ->get();
    
        $response = $this->generalResponse(true,200,'success', null,$activity);
    
        if (count($activity) == 0) {
        $response = $this->generalResponse(false,404,'activity not found', null,null);
        }

        return $response;
    }

    // add activity to company function
    public function addActivityToCompany($activityId, $companyId)
    {
        $activity = companyActivity::where('activity_id',$activityId)
        ->orWhere('company_id',$companyId)
        ->first();
        if (!$activity) {

            $creat = companyActivity::create(['activity_id'=>$activityId,'company_id'=>$companyId])->id;
        
            if ($creat) {
            
                return $this->generalResponse(true,200,'success', null,$this->activityById($creat)->original['data']);
        
            }
        
        } else {
            
            $msg = 'activity exist';
            return $this->generalResponse(false, 409,$msg, null,null);
        
        }
    }


     // un active activity for company function
     public function unActiveActivityForCompany($activityId)
     {
         $activity = companyActivity::select('*')
         ->where('id',$activityId)
         ->first();
         if ($activity) {
 
             $update = companyActivity::where('id',$activityId)->update(['IsActive'=>false])->id;
         
             if ($update) {
             
                 return $this->generalResponse(true,201,'success', null,null);
         
             }
         
         } else {
             
             $msg = 'activity not exist';
             return $this->generalResponse(false, 404,$msg, null,null);
         
         }
     }

      // get  activity in company function
      public function activityByCompanyId($companyId)
      {
          $activity = companyActivity::select('*')
          ->where('company_id',$companyId)
          ->get();
          if (count($activity) != 0) {
              $responseObj = array();

              foreach ($activity as $value) {
                $responseObj[] = $this->activityById($value['activity_id'])->original['data'];
              }

                  return $this->generalResponse(true,200,'success', null,$responseObj);
          
          } else {
              
              $msg = 'activity not exist';
              return $this->generalResponse(false, 404,$msg, null,null);
          
          }
      }
}