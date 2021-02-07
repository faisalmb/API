<?php
namespace App\Traits;
use Illuminate\Support\Str;
use App\Model\branch;
use App\Model\user;
use App\Model\branchPhone;
use App\Model\branchUser;
use App\Model\branchUserRole;
use Carbon\Carbon;
// use phpDocumentor\Reflection\PseudoTypes\True_;

trait Branchfunction
{

  use Userfunction;
  use Rolesfunction;
    // get Branch by id
  public function getBranch($id)
  {
        $branch = branch::where('id', $id)
        ->first();
       
        if ($branch) {

          $branchId = $branch->id;
          $userId = $branch->user_id;

          $user = $this->getuserByid($userId)->original['data'];

          $branchPhone = branchPhone::where('branch_id', $branchId)
          ->get();

          $responseObj = (object) array(
            'branch'=>$branch,
            'branchPhone'=>$branchPhone,
            'creatorInfo'=>$user
          );

          return $this->generalResponse(true,200,'success', null,$responseObj);
        } else {
          return $this->generalResponse(true,404,'branch not found', null,null);
        }


  }



  public function getuserInfoBranch($search,$branchId,$page)
  {
    
        $branchUser = branchUser::select('user_id')
            ->where('branch_id',$branchId)
            ->get('user_id');
        
        $page = $page *10;
        $user = user::select('id','fullname','phone','email','IsActive','IsSuperAdmin','created_at','updated_at')
        ->whereIn('id',$branchUser)
        ->where(function($q) use ($search) {
          $q->where('phone','LIKE',"%".str_ireplace("%20"," ", $search)."%")
            ->orWhere('email','LIKE',"%".str_ireplace("%20"," ", $search)."%")
            ->orWhere('fullname','LIKE',"%".str_ireplace("%20"," ", $search)."%");
            })
        ->skip($page)
        ->take(10)
        ->get();

        if ($user) {
          return $this->generalResponse(true,200,'success', null,$user);
        } else {
          return $this->generalResponse(true,404,'user not found', null,null);
        }

  }




  // get branch by Page
  public function getBranchesByPage($page,$companyId)
  {
        $page = $page *10;
        $branch = branch::where('company_id',$companyId)
        ->skip($page)
        ->take(10)
        ->get();
        $result = array();
        if (count($branch) != 0) {
           foreach ($branch as $key ) {
            $branchInfo = $this->getBranch($key['id'])->original['data'];
            if (!empty($branchInfo)) {
                $result[] = $branchInfo;
              }
           }
           return $this->generalResponse(true,200,'success', null,$result);
        } else {
          return $this->generalResponse(true,404,'branch not found', null,null);
        }

  }

  // get My Branch by Page And Creater Id
  public function getMyBranchUserByPage($page,$branchId)
  {
        $page = $page *10;
        $branchUser = branchUser::where('branch_id', $branchId)
        ->skip($page)
        ->take(10)
        ->get();
        $result = array();
        if ($branchUser) {
           foreach ($branchUser as $key ) {
            $userId = $key['user_id'];
            $user = $this->getuserByid($userId)->original['data'];
            if ($user) {
              $userInfo = array('userInfo' => $user,'IsActive'=>$key['IsActive'],'IsAdmin'=>$key['IsAdmin']
              , 'created_at'=>$key['created_at'], 'updated_at'=>$key['updated_at']);
              $result[] = $userInfo;
            } 
           }
          return $this->generalResponse(true,200,'success', null,$result);
        } else {
          return $this->generalResponse(true,404,'branch not found', null,null);
        }

  }

   // get My Company by Page And Creater Id
   public function getMyBranchesByPage($page,$userId,$companyId)
   {
         $page = $page *10;
         $branch = branch::select('*')
         ->where('user_id', $userId)
         ->where('company_id', $companyId)
         ->skip($page)
         ->take(10)
         ->get();
         $result = array();
         if (count($branch) != 0) {
          foreach ($branch as $key ) {
           $branchInfo = $this->getBranch($key['id'])->original['data'];
           if (!empty($branchInfo)) {
               $result[] = $branchInfo;
             }
          }
          return $this->generalResponse(true,200,'success', null,$result);
       } else {
         return $this->generalResponse(true,404,'branch not found', null,null);
       }
 
   }

      // get My branch by Page And Creater Id
      public function getBranchesThatIWorkForItByPage($page,$userId,$companyId)
      {
            $branch = branch::select('id')
            ->where('company_id',$companyId)
            ->where('IsActive',true)
            ->get('id');

            $page = $page *10;
            $branchUser = branchUser::select('*')
            ->where('user_id', $userId)
            ->where('IsActive',true)
            ->whereIn('branch_id',$branch)
            ->skip($page)
            ->take(10)
            ->get();
            $result = array();
            if (count($branchUser) != 0) {
               foreach ($branchUser as $key ) {
                 $branchInfo = $this->getBranch($key['branch_id'])->original['data'];
                  if (!empty($branchInfo)) {
                      $result[] = $branchInfo;
                    }
                
               }
               return $this->generalResponse(true,200,'success', null,$result);
            } else {
             return $this->generalResponse(true,404,'branch not found', null,null);
            }
    
      }


      public function addRoleToUserInBranch($branchId,$userId,$roles)
      {

        $response = array();
        
        foreach ($roles as $roleId) {

          $obj = $this->roleById($roleId);
           if ($obj->original['status'] == 200) {
           
              $responseObj = '';
              $role = $this->addRoleBranch($branchId,$userId,$roleId);
              
              if ($role) {
                $obj = $this->roleById($roleId)->original['data'];
                $responseObj = (object) array(
                  'status' => $role,
                  'roleId' => $roleId,
                  'name' => $obj->name,
                  'short_name' => $obj->short_name,
                  'code' => $obj->code,
                  'IsActive' => $obj->IsActive,
                  'description' => $obj->description
                );
                $response[] = $responseObj;
              } else {
                $obj = $this->roleById($roleId)->original['data'];
                $responseObj = (object) array(
                  'status' => $role,
                  'roleId' => $roleId,
                  'name' => $obj->name,
                  'short_name' => $obj->short_name,
                  'code' => $obj->code,
                  'IsActive' => $obj->IsActive,
                  'description' => $obj->description
                );
                $response[] = $responseObj;
              }
              
            } else {
              $responseObj = (object) array(
                'status' => false,
                'roleId' => $roleId,
                'short_name' => null,
                'code' => null,
                'IsActive' => null,
                'description' => null
              );
              $response[] = $responseObj;
            }

        }

        return $this->generalResponse(true,200,'success', null, $response);

      }

     public function addRoleBranch($branchId,$userId,$roleId)
     {
        $id = BranchUser::select('id')
        ->where('user_id', $userId)
        ->where('branch_id', $branchId)
        ->first();
        if ($id->id) {

          $branchUserRole = branchUserRole::select('id')
          ->where('branch_user_id', $id->id)
          ->where('role_id', $roleId)
          ->first();

          if (!$branchUserRole) {
            $result = branchUserRole::create(
              ['role_id' =>$roleId,'branch_user_id' =>$id->id]
            );

            if ($result) {

              return true;

            } else {

              return false;

            }

          } else {

            return false;

          }
          
        }else {

          return false;

        }
        
     }

      // add user to Branch 
      public function addBranchUser($branchId,$userId,$IsAdmin,$IsActive,$roleId)
      {
            
            $BranchUser = BranchUser::select('*')
            ->where('user_id', $userId)
            ->where('branch_id', $branchId)
            ->first();
           
            if (!$BranchUser) {
              
              $createId = BranchUser::create(
                ['user_id' => $userId,'branch_id' => $branchId,'IsActive' => $IsActive
                ,'IsAdmin' => $IsAdmin]
              )->id;
             
              $addRole = $this->addRoleBranch($branchId,$userId,$roleId);
            
              return $this->generalResponse(true,200,'success', null,null);
             
            } else {
              $msg = 'user already exists';
              return $this->generalResponse(true,409,$msg, null,null);
            }
    
      }



       // active and disActive or admin and not admin user in company 
       public function changeBranchUser($branchId,$userId,$IsAdmin,$IsActive)
       {    
             $branchUser = branchUser::select('*')
             ->where('user_id', $userId)
             ->where('branch_id', $branchId)
             ->first();
            
             if ($branchUser) {
               
               $result = branchUser::where('user_id', $userId)->where('branch_id', $branchId)->update(
                 ['IsActive' => $IsActive
                 ,'IsAdmin' => $IsAdmin]
               );
               return $this->generalResponse(true,200,'success', null,null);
             } else {
               $msg = 'user not exists';
               return $this->generalResponse(true,404,$msg, null,null);
             }
     
       }



   // add Branch function
   public function addBranchByAdmin($userId,$companyId,$name,$location,$type,$primaryPhone)
   {

      $branchPhoneCheck = branchPhone::select('*')
      ->where('phone', $primaryPhone)
      ->first();
      if (!$branchPhoneCheck) {
         $createId = branch::create(
           ['name' => $name,'location' => $location,'type' => $type
           ,'company_id' => $companyId,'user_id' => $userId]
         )->id;

         if ($createId) {
         
          $branchPhone = branchPhone::create(['branch_id'=>$createId,'phone' => $primaryPhone,'type' => 'primary']);
         
          return $this->generalResponse(true,200,'success', null,$this->getBranch($createId)->original['data']);
         }else {
          $msg = 'internal server error';
          return $this->generalResponse(false,500,$msg, null,null);
         }
        
       } else {
         $msg='branch already exists';
         return $this->generalResponse(false,409,$msg, null,null);
       }

   }

 


    public function updateBranch($companyId,$branchId,$name,$location,$type,$IsActive)
    {
      
      $branch = branch::select('*')
      ->where('name', $name)
      ->where('company_id', $companyId)
      ->first();
      if ($branch) {
        if ($branch->id == $branchId) {
          return $this->exeUpdateBranch($branchId,$name,$location,$type,$IsActive);
        } else {
          $msg = 'this branch already registered';
          return $this->generalResponse(false,409,$msg, null,null);
        }
  
      } else {
            return $this->exeUpdateBranch($branchId,$name,$location,$type,$IsActive);
      }
    }

     // Update user function
   public function exeUpdateBranch($branchId,$name,$location,$type,$IsActive)
   {

         $branch= branch::where('id', $branchId)->update(['name' => $name,'location' => $location, 'type' => $type
         ,'IsActive' => $IsActive]);

         if ($branch) {
           
           return $this->getBranch($branchId);
         } else {
           $msg = 'is already updated' ;
           return $this->generalResponse(false,409,$msg, null,null);
         }

   }

}