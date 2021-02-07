<?php
namespace App\Traits;
use Illuminate\Support\Str;
use App\Model\company;
use App\Model\companyActivity;
use App\Model\user;
use App\Model\companyPhone;
use App\Model\companyUser;
use Carbon\Carbon;


trait Companyfunction {

  use Activityfunction;
  use Cityfunction;
  // get Company by id
  public function getCompany($id)
  {
        $company = company::where('id', $id)
        ->first();

       
        $return = array();
        if ($company) {
          $companyId = $company->id;
          $cityId = $company->city_id;
          $companyActivity = $this->activityByCompanyId($companyId)->original['data'];
          $companyPhone = companyPhone::select('*')
          ->where('company_id', $companyId)
          ->get();

          $user = user::select('id','fullname','phone','email','IsActive','created_at','updated_at')
          ->where('id', $company->user_id)
          ->first();

          $companyLocation = $this->cityById($cityId)->original['data'];;

          $responseObj = (object) array(
            'company'=>$company,
            'companyActivity'=>$companyActivity,
            'companyPhone'=>$companyPhone,
            'companyLocation'=>$companyLocation,
            'creatorInfo'=>$user
          );

          // $result = array('id'=>$company->id,'name'=>$company->name,'country'=>$company->country,'state'=>$company->state
          // ,'city'=>$company->city,'address'=>$company->address,'active'=>$company->active
          // ,'official'=>$company->official,'phones'=>$companyPhone,'added_by'=>$user,'created_at'=>$company->created_at,'updated_at'=>$company->created_at);

          return $this->generalResponse(true,200,'success', null,$responseObj);
        } else {
          return $this->generalResponse(true,404,'company not found', null,null);
        }


  }



  public function getuserInfoCompany($search,$companyId,$page)
  {
    
        $companyUser = companyUser::select('user_id')
            ->where('company_id',$companyId)
            ->get('user_id');
        
        $page = $page *10;
        $user = user::select('id','fullname','phone','email','IsActive','IsSuperAdmin','created_at','updated_at')
        ->whereIn('id',$companyUser)
        ->where(function($q) use ($search) {
          $q->where('phone','LIKE',"%".str_ireplace("%20"," ", $search)."%")
            ->orWhere('email','LIKE',"%".str_ireplace("%20"," ", $search)."%")
            ->orWhere('fullname','LIKE',"%".str_ireplace("%20"," ", $search)."%");
            })
        ->skip($page)
        ->take(10)
        ->get();

        if (count($user) != 0) {
          return $this->generalResponse(true,200,'success', null,$user);
        } else {
          return $this->generalResponse(true,404,'user not found', null,null);
        }


  }




  // get Company by Page
  public function getCompaniesByPage($page)
  {
        $page = $page *10;
        $company = company::skip($page)
        ->take(10)
        ->get();
        $result = array();
        if ($company) {
           foreach ($company as $key ) {
            $companyInfo = $this->getCompany($key['id'])->original['data'];
            if (!empty($companyInfo)) {
                $result[] = $companyInfo;
              }
           }
          return $this->generalResponse(true,200,'success', null,$result);
        } else {
          return $this->generalResponse(true,404,'user not found', null,null);
        }

  }

  // get My Company by Page And Creater Id
  public function getMyCompanyUserByPage($page,$companyId)
  {
        $page = $page *10;
        $companyUser = companyUser::where('company_id', $companyId)
        ->skip($page)
        ->take(10)
        ->get();
        $result = array();
        if ($companyUser) {
           foreach ($companyUser as $key ) {
            $user = user::select('id', 'fullname', 'phone', 'email', 'IsActive', 'IsSuperAdmin', 'created_at', 'updated_at')
            ->where('id', $key['user_id'])
            ->first();
            if ($user) {
              $userInfo = array('userInfo' => $user,'IsActive'=>$key['IsActive'],'IsAdmin'=>$key['IsAdmin']
              , 'created_at'=>$key['created_at'], 'updated_at'=>$key['updated_at']);
              $result[] = $userInfo;
            } 

           }

          return $this->generalResponse(true,200,'success', null,$result);
        } else {
          return $this->generalResponse(true,404,'users not found', null,null);
        }

  }

   // get My Company by Page And Creater Id
   public function getMyCompaniesByPage($page,$userId)
   {
         $page = $page *10;
         $company = company::select('*')
         ->where('user_id', $userId)
         ->skip($page)
         ->take(10)
         ->get();
         $result = array();
         if ($company) {
            foreach ($company as $key ) {
              $companyInfo = $this->getCompany($key['id'])->original['data'];
              if (!empty($companyInfo)) {
                  $result[] = $companyInfo;
                } 
            }
            return $this->generalResponse(true,200,'success', null,$result);
          } else {
            return $this->generalResponse(true,404,'user not found', null,null);
          }
 
   }

      // get My Company by Page And Creater Id
      public function getCompaniesThatIWorkForItByPage($page,$userId)
      {
            $page = $page *10;
            $companyUser = companyUser::select('*')
            ->where('user_id', $userId)
            ->skip($page)
            ->take(10)
            ->get();
            $result = array();
            if ($companyUser) {
               foreach ($companyUser as $key ) {
                 $companyInfo = $this->getCompany($key['company_id'])->original['data'];
                  if (!empty($companyInfo)) {
                      $result[] = $companyInfo;
                    }
                
               }
              return $this->generalResponse(true,200,'success', null,$result);
            } else {
              return $this->generalResponse(true,404,'user not found', null,null);
            }
    
      }



      // add user to company 
      public function addCompanyUser($companyId,$userId,$IsAdmin,$IsActive)
      {
            
            $companyUser = companyUser::select('*')
            ->where('user_id', $userId)
            ->where('company_id', $companyId)
            ->first();
           
            if (!$companyUser) {
              $id = $this->generateId();
              $result = companyUser::create(
                ['id' => $id,'user_id' => $userId,'company_id' => $companyId,'IsActive' => $IsActive
                ,'IsAdmin' => $IsAdmin]
              );

            return $this->generalResponse(true,200,'success', null,$result);
          } else {
            $msg='user already exists';
            return $this->generalResponse(true,409,$msg, null,null);
          }
    
      }



       // active and disActive or admin and not admin user in company 
       public function changeCompanyUser($companyId,$userId,$IsAdmin,$IsActive)
       {
             
             $companyUser = companyUser::select('*')
             ->where('user_id', $userId)
             ->where('company_id', $companyId)
             ->first();
            
             if ($companyUser) {
               
               $result = companyUser::where('user_id', $userId)->where('company_id', $companyId)->update(
                 ['IsActive' => $IsActive
                 ,'IsAdmin' => $IsAdmin]
               );
               return $this->generalResponse(true,200,'success', null,null);
             } else {
               $msg='user not exists';
               return $this->generalResponse(true,404,$msg, null,null);
             }
     
       }



   // add add Company function
   public function addCompanyByUser($userId,$name,$countryId,$stateId,$cityId,$address,$taxNumber,$primaryPhone,$activityId)
   {
     
     $company = company::select('*')
      ->where('user_id', $userId)
      ->first();
      $companyPhoneCheck = companyPhone::select('*')
      ->where('phone', $primaryPhone)
      ->first();
      if (!$company && !$companyPhoneCheck) {
         $createId = company::create(
           ['name' => $name,'country_id' => $countryId,'state_id' => $stateId
           ,'city_id' => $cityId,'address' => $address,'tax_number' => $taxNumber,'user_id' => $userId]
         )->id;

         if ($createId) {
         
          $companyPhone = companyPhone::create(['phone' => $primaryPhone,'type' => 'primary','company_id' => $createId]);
         
          $companyUser = companyUser::create(['user_id' => $userId,'IsAsmin' => true,'company_id' => $createId]);
          
          $companyActivity = companyActivity::create(['activity_id' => $activityId,'company_id' => $createId]);
         

           $message = "شكرا للتسجيل في  خدماتنا "."\n".$name."\n"."الخدمة التجريبيه متاحة لمدة 30 يوما"."\n"."للمزيد من الخدمات قم بزياره موقعنا"."\n"."https://servatna.com";
           $msg ='';
           $send=$this->sendUserSms($primaryPhone,$message);
           return $this->generalResponse(true,200,'success', null,$this->getCompany($createId)->original['data']);
         }else {
          $msg = 'internal server error';
          return $this->generalResponse(true,500,$msg, null,null);
         }
        
       } else {
         $msg='only one company has allowed';
         return $this->generalResponse(true,409,$msg, null,null);
       }

   }

    // add add Company by sys Admin function
    public function addCompanyBySysAdmin($adminId,$userId,$name,$countryId,$stateId,$cityId,$address,$taxNumber,$primaryPhone,$activityId)
    {
      $companyId = $this->generateId();
      $company = company::where('tax_number', $taxNumber)
        ->first();
        $companyPhoneCheck = companyPhone::where('phone', $primaryPhone)
        ->first();
        if (!$company && !$companyPhoneCheck) {
          $createId = company::create(
            ['name' => $name,'country_id' => $countryId,'state_id' => $stateId
            ,'city_id' => $cityId,'address' => $address,'tax_number' => $taxNumber,'user_id' => $userId]
          )->id;
 
          if ($createId) {
          
           $companyPhone = companyPhone::create(['phone' => $primaryPhone,'type' => 'primary','company_id' => $createId]);
          
           $companyUser = companyUser::create(['user_id' => $adminId,'IsAsmin' => true,'company_id' => $createId]);
           
           $companyActivity = companyActivity::create(['activity_id' => $activityId,'company_id' => $createId]);
          
 
            $message = "شكرا للتسجيل في  خدماتنا "."\n".$name."\n"."الخدمة التجريبيه متاحة لمدة 30 يوما"."\n"."للمزيد من الخدمات قم بزياره موقعنا"."\n"."https://servatna.com";
            $msg ='';
            $send=$this->sendUserSms($primaryPhone,$message);
            return $this->generalResponse(true,200,'success', null,$this->getCompany($createId)->original['data']);
          }else {
           $msg = 'internal server error';
           return $this->generalResponse(true,500,$msg, null,null);
          }
         
        } else {
          $msg='company already exist';
          return $this->generalResponse(true,409,$msg, null,null);
        }

    }


    public function updateCompany($companyId,$name,$countryId,$stateId,$cityId,$address,$taxNumber)
    {
      
      $company = company::select('*')
      ->where('tax_number', $taxNumber)
      ->first();
      if ($company) {
        if ($company->id == $companyId) {
          return $this->exeUpdateCompany($companyId,$name,$countryId,$stateId,$cityId,$address,$taxNumber);
        } else {
          $msg = 'this company already registered';
          return $this->generalResponse(true,409,$msg, null,null);
        }
  
      } else {
            return $this->exeUpdateCompany($companyId,$name,$countryId,$stateId,$cityId,$address,$taxNumber);
      }
    }

     // Update user function
   public function exeUpdateCompany($companyId,$name,$countryId,$stateId,$cityId,$address,$taxNumber)
   {

         $update= company::where('id', $companyId)->update(['name' => $name,'country_id' => $countryId, 'state_id' => $stateId
         ,'city_id' => $cityId,'address' => $address, 'tax_number' => $taxNumber]);

         if ($update) {
           
          return $this->generalResponse(true,200,'success', null,$this->getCompany($companyId)->original['data']);
        
        } else {
           $msg = array('msg' => 'is already updated' );
           return $this->generalResponse(true,409,$msg, null,null);
         }

   }



  



}
