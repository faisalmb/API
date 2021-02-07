<?php
namespace App\Traits;

use App\Model\role;
use App\Model\branchUserRole;
use App\Traits\Genralfunction;

trait Rolesfunction
{
    use Genralfunction;

    // get role by id
    public function roleById($id)
    {
        $role = role::select('*')
        ->where('id',$id)
        ->first();

        if ($role) {
            return $this->generalResponse(true,200,'success', null,$role);
        } else {
            return $this->generalResponse(false,404,'role not found', null,null);
        }
    }

    // add role function
    public function addRole($name, $shortName, $description, $code)
    {
        $role = role::select('*')
        ->where('name',$name)
        ->orWhere('short_name',$shortName)
        ->orWhere('code',$code)
        ->first();
        if (!$role) {

            $creat = role::create(['name'=>$name,'short_name'=>$shortName,'code'=>$code,'description'=>$description])->id;
        
            if ($creat) {
            
                return $this->generalResponse(true,200,'success', null,$this->roleById($creat)->original['data']);
        
            }
        
        } else {
            
            $msg = 'role exist';
            return $this->generalResponse(false, 409,$msg, null,null);
        
        }
    }


    // update Role function
    public function updateRole($id,$name, $shortName, $description, $code,$IsActive)
    {
        $role = role::select('*')
        ->where('name',$name)
        ->orWhere('short_name',$shortName)
        ->orWhere('code',$code)
        ->first();

        if (!$role) {

            return $this->exeUpdateRole($id,$name, $shortName, $description, $code,$IsActive);
        
        } else {

            if ($role->id == $id) {
                return $this->exeUpdateRole($id,$name, $shortName, $description, $code,$IsActive);
            } else {
                $msg = 'role exist';
            return $this->generalResponse(false, 409,$msg, null,null);
            }
        
        }
    }

   // execute update role function
   private function exeUpdateRole($id,$name, $shortName, $description, $code,$IsActive)
   {
        $creat = role::where('id',$id)->update(['name'=>$name,'short_name'=>$shortName,'code'=>$code,'description'=>$description
        ,'IsActive'=>$IsActive]);
        if ($creat) {
            return $this->generalResponse(true,200,'success', null,$this->roleById($id)->original['data']);
        } else {
            $msg = 'Cannot create role';
            return $this->generalResponse(false, 500,$msg, null,null);
        }
   }

   // get role by page
   public function rolesByPage($page)
   {
       $page=$page*20;
       $role = role::select('*')
       ->skip($page)
       ->take(20)
       ->get();
      
   
       $response = $this->generalResponse(true,200,'success', null,$role);
   
       if (count($role) == 0) {
        $response = $this->generalResponse(false,404,'role not found', null,null);
       }

       return $response;
   }

    // get role by info and Page
    public function rolesByInfoAndPage($page,$search)
    {
        $page=$page*20;
        $role = role::select('*')
        ->where(function($q) use ($search) {
            $q->where('name','LIKE',"%".str_ireplace("%20"," ", $search)."%")
              ->orWhere('short_name','LIKE',"%".str_ireplace("%20"," ", $search)."%")
              ->orWhere('code','LIKE',"%".str_ireplace("%20"," ", $search)."%");
              })
        ->skip($page)
        ->take(20)
        ->get();
    
        $response = $this->generalResponse(true,200,'success', null,$role);
    
        if (count($role) == 0) {
        $response = $this->generalResponse(false,404,'role not found', null,null);
        }

        return $response;
    }

    // add role to company function
    public function addRoleToUser($roleId, $branchUserId)
    {
        $role = branchUserRole::select('*')
        ->where('role_id',$roleId)
        ->orWhere('branch_user_id',$branchUserId)
        ->first();
        if (!$role) {

            $creat = branchUserRole::create(['role_id'=>$roleId,'branch_user_id'=>$branchUserId])->id;
        
            if ($creat) {
            
                return $this->generalResponse(true,200,'success', null,null);
        
            }
        
        } else {
            
            $msg = 'role exist';
            return $this->generalResponse(false, 409,$msg, null,null);
        
        }
    }


     //remove Role Form User function
     public function removeRoleFormUser($roleId)
     {
         $role = branchUserRole::select('*')
         ->where('id',$roleId)
         ->first();
         if ($role) {
 
             $update = branchUserRole::whereIn('id',$roleId)->delete();
         
             if ($update) {
             
                 return $this->generalResponse(true,201,'success', null,null);
         
             }
         
         } else {
             
             $msg = 'role not exist';
             return $this->generalResponse(false, 404,$msg, null,null);
         
         }
     }

      // get  role in branch for user function
      public function roleForUserInBranch($branchUserId)
      {
          $role = branchUserRole::select('*')
          ->where('branch_user_id',$branchUserId)
          ->get();
          if (count($role) != 0) {
              $responseObj = array();

              foreach ($role as $value) {
                $responseObj[] = $this->roleById($value['role_id'])->original['data'];
              }

                  return $this->generalResponse(true,200,'success', null,$responseObj);
          
          } else {
              
              $msg = 'role not exist';
              return $this->generalResponse(false, 404,$msg, null,null);
          
          }
      }
}