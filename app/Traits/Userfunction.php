<?php
namespace App\Traits;

use App\Model\customer;
use App\Model\branchCustomer;
use Illuminate\Support\Str;


use App\Model\user;

use Carbon\Carbon;
use App\Traits\Countryfunction;


trait Userfunction {
  use Countryfunction;

  // get user function
  // public function getUserByCompanyId($companyId,$page)
  // {
  //       $page = $page *10;
  //       $users = user::select('id as userId','com_id as companyId','phone as phone','mail','name','type','is_active as isActive','created_at','updated_at')
  //       ->where('com_id', $companyId)
  //       ->skip($page)
  //       ->take(10)
  //       ->get();
        
  //       if ($users) {
  //         $userByCompany = array();
  //         foreach ($users as $user) {

  //           $typeDefinition;
  //           switch ($user['type']) {
  //             case '1':
  //               $typeDefinition = 'admin';
  //               break;
  //             case '2':
  //               $typeDefinition = 'user';
  //               break;
  //             case '3':
  //               $typeDefinition = 'superAdmin';
  //               break;
  //             case '4':
  //               $typeDefinition = 'cashier ';
  //               break;
              
  //             default:
  //             $typeDefinition = 'unknown ';
  //               break;
  //           }
            
  //           $company = company::select('id  as companyId', 'name', 'phone', 'location', 'created_at', 'updated_at')
  //           ->where('id',$user['companyId'])
  //           ->first();

  //           $storeAccess = storeAccess::select('st_id as storeId')
  //           ->where('access_id', $user['userId'])
  //           ->get();

  //           $arrayOfStore = array(); 
  //           if ($storeAccess) {
  //             foreach ($storeAccess as $value) {
  //               $store = storeInfo::select('id  as storeId', 'com_id as companyId', 'name', 'location', 'type', 'currency', 'currency_def as currencyTag', 'created_at', 'updated_at')
  //               ->where('id',$value['storeId'])
  //               ->first();

  //               $arrayOfStore[] = $store;
  //             }
  //           }

  //           $arrayResult[] = array('userId' =>$user->userId,'name' =>$user->name,'mail' => $user->mail,'phone' => $user->phone ,'type' => $user->type,'typeDefinition'=>$typeDefinition,'isActive' => $user->isActive, 'created_at' =>$user->created_at, 'updated_at' =>$user->updated_at,'companyInfo' =>$company,'storeInfo' =>$arrayOfStore);
                    
  //         }
  //         $userByCompany['data'] = $arrayResult;
  //         return response()->json($userByCompany, 200);
  //       } else {
  //         // $msg = array('msg' => 'internal server error' );
  //         return response()->json($user, 404);
  //       }


  // }

  //   // get user function
  //   public function getUserByStoreId($companyId,$userId,$page)
  //   {       
  //         $page = $page *10;
  //         $userStoreAccess = storeAccess::select('st_id as storeId','access_id as userId')
  //         ->where('access_id', $userId)
  //         ->first();
  //         $storeAccess = storeAccess::select('st_id as storeId','access_id as userId')
  //         ->where('st_id', $userStoreAccess->storeId)
  //         ->skip($page)
  //         ->take(10)
  //         ->get();
  //         if ($storeAccess) {
  //           $userByStore = array();
  //           $store = storeInfo::select('id  as storeId', 'com_id as companyId', 'name', 'location', 'type', 'currency', 'currency_def as currencyTag', 'created_at', 'updated_at')
  //           ->where('id', $userStoreAccess->storeId)
  //           ->first();
  //           $company = company::select('id  as companyId', 'name', 'phone', 'location', 'created_at', 'updated_at')
  //           ->where('id',$companyId)
  //           ->first();
  //           foreach ($storeAccess as $value) {
  //             $user = user::select('id as userId','com_id as companyId','phone as phone','mail','name','type','is_active as isActive', 'created_at', 'updated_at')
  //             ->where('id', $value['userId'])
  //             ->first();
  //             if ($user) {
  //               $typeDefinition;
  //               switch ($user->type) {
  //                 case '1':
  //                   $typeDefinition = 'admin';
  //                   break;
  //                 case '2':
  //                   $typeDefinition = 'user';
  //                   break;
  //                 case '2':
  //                   $typeDefinition = 'superAdmin';
  //                   break;
  //                 case '4':
  //                   $typeDefinition = 'cashier ';
  //                   break;
                  
  //                 default:
  //                 $typeDefinition = 'unknown ';
  //                   break;
  //               }
                

  //               }
                
      
  //               $arrayResult[] = array('userId' =>$user->userId,'name' =>$user->name,'mail' => $user->mail,'phone' => $user->phone ,'type' => $user->type,'typeDefinition'=>$typeDefinition,'isActive' => $user->isActive, 'created_at' =>$user->created_at, 'updated_at' =>$user->updated_at);
                        
  //         }
  //         $userByStore['data'] = $arrayResult;
  //         $userByStore['companyInfo'] = $company;
  //         $userByStore['storeInfo'] = $store;
  //         return response()->json($userByStore, 200);
  //         } else {
  //           // $msg = array('msg' => 'internal server error' );
  //           return response()->json($user, 404);
  //         }
  
  
  //   }

  public function getuserByid($id)
  {

        $user = user::select('id', 'fullname', 'phone', 'email', 'IsActive', 'IsSuperAdmin','IsConfirmedPhone','IsConfirmedEmaile', 'created_at', 'updated_at')
        ->where('id', $id)
        ->first();

        if ($user) {
          return $this->generalResponse(true,200,'success', null,$user);
        } else {
          
          return $this->generalResponse(false,404,'not found', null,null);
        }


  }


  public function getuserInfo($search,$page)
  {
        $page = $page *10;
        $user = user::select('id', 'fullname', 'phone', 'email', 'IsActive', 'IsSuperAdmin','IsConfirmedPhone','IsConfirmedEmaile', 'created_at', 'updated_at')
        ->where(function($q) use ($search) {
          $q->where('phone','LIKE',"%".str_ireplace("%20"," ", $search)."%")
            ->orWhere('email','LIKE',"%".str_ireplace("%20"," ", $search)."%")
            ->orWhere('fullname','LIKE',"%".str_ireplace("%20"," ", $search)."%");
            })
        ->skip($page)
        ->take(10)
        ->get();

        if (!empty($user)) {
          return $this->generalResponse(true,200,'success', null,$user);
        } else {
          return $this->generalResponse(false,404,'not found', null,null);
        }


  }


  public function login($phone,$password)
    {
      $n = 6;
      $otp= $this->generateNumericOTP($n);
      $token=hash('sha256',mt_rand(10,999999).$otp);
     
      $user = user::select('id', 'fullname', 'phone', 'email', 'IsActive', 'IsSuperAdmin','IsConfirmedPhone','IsConfirmedEmaile', 'created_at', 'updated_at')
      ->where('password',$password)
      ->where('phone',$phone)
      ->first();

      if ($user && $user->IsActive && $user->IsConfirmedPhone) {
        $update= user::where('id', $user->id)->update(['token' => $token]);
        //   ->where('id', $user->id);
        if ($update) {

          $arrayResult = array('info' =>$user,'token' => $token);
          return $this->generalResponse(true,200,'success', null,$arrayResult);
          
        } else {
          $msg = 'internal server error';
          return $this->generalResponse(false,500,$msg, null,null);
        }

      }else {
        if ($user && !$user->IsActive) {
          $msg = 'user not activated';
          return $this->generalResponse(false,401,$msg, null,null);
        } else {
          $msg = 'User Name or Password incorrect';
          return $this->generalResponse(false,404,$msg, null,null);
        }


      }

   }

   // add user function
   public function addUser($phone,$email,$fullname,$countryId)
   {
     
    $country = $this->countryById($countryId)->original['data'];
      
    if ($country) {
        
      // $userId = $this->generateId();
      $phone = $country->phoneCode.$phone;
      $user = user::select('*')
        ->where('phone', $phone)
        ->first();
        if (!$user) {
          $id = user::create(
            ['phone' => $phone,'email' => $email, 'fullname' => $fullname, 'country_id' => $countryId]
          )->id;

          if ($id) {
              $validatePhone = $this->genCoderesetPasswod($phone);
              $customer = customer::select('*')
              ->where('phone', $phone)
              ->first();
              if (!$customer) {
                customer::create(
                  ['phone' => $phone,'user_id' => $id]
                );
              }else {
                customer::where('phone',$phone)->update(['user_id' => $id]);
              }
            
              $arrayResult = array('info' => $this->getuserByid($id)->original['data'],'validate_phone'=>$validatePhone->original);
              return $this->generalResponse(true,200,'success', null,$arrayResult);
          } else {
            $msg = 'internal server error';
            return $this->generalResponse(false,500,$msg, null,null);
          }

        } else {
          $msg='phone number exist';
          return $this->generalResponse(false,409,$msg, null,null);
        }

      } else {
        $msg='country not exist';
          return $this->generalResponse(false,400,$msg, null,null);
      }
    
     

   }

  public function upadteRaote($info,$email,$fullname)
  {
    $userId = $info->id;
    $user = user::select('*')
    ->where('id', $userId)
    ->first();
    
    if ($user) {
      
      

        return $this->UpdateUser($userId,$email,$fullname);

        


    } else {
      $msg = 'this user not registered';
      return $this->generalResponse(false,404,$msg, null,null);
    }
  }
   // Update user function
   public function UpdateUser($userId,$email,$fullname)
   {

         $update= user::where('id', $userId)->update(['email' => $email, 'fullname' => $fullname]);

         if ($update) {
           $arrayResult = $this->getuserByid($userId)->original['data'];
           
           return $this->generalResponse(true,200,'success', null,$arrayResult);
         } else {
           $msg = 'is already updated';
           return $this->generalResponse(false,409,$msg, null,null);
         }

   }


  // Update phone function
  public function changePhone($phone,$otpcode,$userId)
  {

     
      $recover = NULL;
      $token = NULL;
      
      $user = user::select('*')
      ->where('otp',$otpcode)
      ->where('id',$userId)
      ->first();

      if ($user && $user->IsActive) {
          $update= user::where('id', $user->id)->update(['phone' => $phone,'otp' => NULL,'recover' =>$recover,'token' =>$token,'IsConfirmedPhone' =>true]);
          
          if ($update) {
            $arrayResult = $this->getuserByid($userId)->original['data'];
            $customer = customer::select('*')
            ->where('user_id',$userId)
            ->first();
            if ($customer) {
              customer::where('id', $customer->id)->update(['phone' => $phone]);
              branchCustomer::where('customer_id', $customer->id)->update(['phone' => $phone]);
            }else {
              customer::create(
                ['phone' => $phone,'user_id' => $userId]
              );
            }
            return $this->generalResponse(true,200,'success', null,$arrayResult);
          } else {
            $msg = 'is already change' ;
            return $this->generalResponse(false,409,$msg, null,null);
          }

        }else {
          if (!$user) {
            $msg = 'user not found';
            return $this->generalResponse(false,404,$msg, null,null);
          } else {
            $msg = 'user not activated' ;
            return $this->generalResponse(false,401,$msg, null,null);
          }

        }
      
  }


  public function genCodeChanePhone($phone,$userId)
  {
        $n = 6;
        $otp= $this->generateNumericOTP($n);
        $recover=hash('sha256',mt_rand(10,999999).$otp);
        $user = user::select('*')
        ->where('id',$userId)->first();
        if ($user) {
         $recoverUpdate = user::where('id', $user->id)
            ->update(['recover' => $recover,'otp' => $otp]);
         if ($recoverUpdate) {
           $message = "كود التحقق هو \n".$otp;
           $msg ='';
           $send=$this->sendUserSms($phone,$message);
           if ($send) {
             $msg= array('phone' => $phone,'token' => $recover);
             return $this->generalResponse(true,200,'success', null,$msg);
           } else {
            
             return $this->generalResponse(false,502,'failure send sms', null,$phone);
           }
          }
        }else {
        
         return $this->generalResponse(false,404,'not found', null,$phone);
        }
 }


    // Update user function
    public function activateUser($userId,$IsActive,$IsSuperAdmin)
    {
  
          $update= user::where('id', $userId)->update(['IsActive' => $IsActive,'IsSuperAdmin' => $IsSuperAdmin]);
  
          if ($update) {
            $arrayResult = $this->getuserByid($userId)->original['data'];
            return $this->generalResponse(true,200,'success', null,$arrayResult);
          } else {
            $msg = 'is already updated';
            return $this->generalResponse(false,409,$msg, null,null);
          }
  
    }



   public function updatePasswod($userId,$password)
     {
       $update= user::where('id', $userId)->update(['password' => $password,'token' => NULL]);

       if ($update) {
         $msg = 'Password updated';
         return $this->generalResponse(false,200,$msg, null,null);
       } else {
         $msg = array('msg' => 'is already updated' );
         return $this->generalResponse(false,409,$msg, null,null);
       }

    }

    public function resetPasswod($phone,$otpcode,$userId)
      {
        $n = 6;
        $otp= $this->generateNumericOTP($n);
        $Passwordgen = mt_rand(10,999999).$otp;
        $Password=hash('sha256',$Passwordgen);
        $code=$otpcode;
        $recover = NULL;
        $token = NULL;
        
        $user = user::select('id', 'phone', 'email', 'fullname', 'IsActive', 'token', 'created_at')
        ->where('phone',$phone)
        ->where('otp',$code)
        ->where('id',$userId)
        ->first();

        if ($user && $user->IsActive) {
            $update= user::where('id', $user->id)->update(['password' => $Password,'otp' => NULL,'recover' =>$recover,'token' =>$token,'IsConfirmedPhone' =>true]);

            if ($update) {
               $arrayResult = (object) array(
                 'userInfo'=> $this->getuserByid($userId)->original['data'],
                'password' => $Passwordgen);

               return $this->generalResponse(true,200,'success', null,$arrayResult);
            } else {
              $msg = 'is already reset' ;
              return $this->generalResponse(false,409,$msg, null,null);
            }

          }else {
            if (!$user) {
              $msg = 'user not found';
              return $this->generalResponse(false,404,$msg, null,null);
            } else {
              $msg = 'user not activated' ;
              return $this->generalResponse(false,401,$msg, null,null);
            }


          }


     }


     public function genCoderesetPasswod($phone)
       {
             $n = 6;
             $otp= $this->generateNumericOTP($n);
             $recover=hash('sha256',mt_rand(10,999999).$otp);
             $user = user::select('*')
             ->where('phone',$phone)->first();
             if ($user) {
              $recoverUpdate = user::where('phone', $user->phone)
                 ->update(['recover' => $recover,'otp' => $otp]);
              if ($recoverUpdate) {
                $message = "كود التحقق هو \n".$otp;
                $msg ='';
                $send=$this->sendUserSms($phone,$message);
                if ($send) {
                  $msg= array('phone' => $phone,'token' => $recover);
                  return $this->generalResponse(true,200,'success', null,$msg);
                } else {
                 
                  return $this->generalResponse(false,502,'failure send sms', null,$phone);
                }
               }
             }else {
             
              return $this->generalResponse(false,404,'not found', null,$phone);
             }
      }

      


}
