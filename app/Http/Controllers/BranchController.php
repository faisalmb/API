<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class BranchController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */


     public function addBranchByAdminRequest(Request $request)
     {
         $this->validate($request, [
           'primaryPhone' => 'required|min:4',
           'name' => 'required|string',
           'location' => 'required|string',
           'type' => 'required|string',
           ]);

           
         $userId = $this->checktoken($request)->id;
         $companyId = $this->checkHeadersCompanyId($request)->content;
         $name =  $request->input('name');
         $location =  $request->input('location');
         $type =  $request->input('type');
         $primaryPhone =  $request->input('primaryPhone');         
         return $this->addBranchByAdmin($userId,$companyId,$name,$location,$type,$primaryPhone);
     }




    // Get branches  by   paging
    public function getBranchesByPageRequest(Request $request)
      {
            $page = $request->page;
            $companyId = $this->haveId($request,'companyId')->content;
            return $this->getBranchesByPage($page,$companyId);
      } 


    // Get branches  by   paging
      public function getMyBranchesByPageRequest(Request $request)
      {
            $page = $request->page;
            $userId = $this->checktoken($request)->id;
            $companyId = $this->haveId($request,'companyId')->content;
            return $this->getMyBranchesByPage($page,$userId,$companyId);
      } 

      // Get branches That I Work For It by paging
      public function getBranchesThatIWorkForItByPageRequest(Request $request)
      {
            $page = $request->page;
            $userId = $this->checktoken($request)->id;
            $companyId = $this->haveId($request,'CompanyId')->content;
            return $this->getBranchesThatIWorkForItByPage($page,$userId,$companyId);
      } 


      // Get user  by name or phone  paging
      public function GetUserInBranchbyinfoRequest(Request $request)
      {
            $this->validate($request, [
              'search' => 'required'
              ]);
            $page = $request->page;
            $search =  $request->input('search');
            $info = $this->haveId($request,'branchId');
            $branchId = $info->content;
            return $this->getuserInfoBranch($search,$branchId,$page);
      } 


      // Get user in branch  by  paging
      public function GetUserInBranchRequest(Request $request)
      {
            $page = $request->page;
            $info = $this->haveId($request,'branchId');
            $branchId = $info->content;
            return $this->getMyBranchUserByPage($page,$branchId);
      } 

      // add user to Branch
      public function AddUserToBranchByUserRequest(Request $request)
      {
            $this->validate($request, [
              'userId' => 'required|string',
              'IsAdmin' => 'required|boolean',
              'IsActive' => 'required|boolean',
              'roleId' => 'required|string'
              ]);
            $branchId = $this->haveBrach($request)->content;
            $userId = $request->input('userId');
            $IsActive = $request->input('IsActive');
            $IsAdmin = $request->input('IsAdmin');
            $roleId = $request->input('roleId');
            return $this->addBranchUser($branchId,$userId,$IsAdmin,$IsActive,$roleId);
      }

      public function AddUserToBranchRequest(Request $request)
      {
            $this->validate($request, [
              'userId' => 'required|string',
              'branchId' => 'required|string',
              'IsAdmin' => 'required|boolean',
              'IsActive' => 'required|boolean',
              'roleId' => 'required|string'
              ]);
            $branchId = $request->input('branchId');
            $userId = $request->input('userId');
            $IsActive = $request->input('IsActive');
            $IsAdmin = $request->input('IsAdmin');
            $roleId = $request->input('roleId');
            return $this->addBranchUser($branchId,$userId,$IsAdmin,$IsActive,$roleId);
      }



      public function AddRoleToUserInBranchRequest(Request $request)
      {
            $this->validate($request, [
              'userId' => 'required|string',
              'roles' => 'required|array',
              'roles.*' => 'required',
              ]);
            $info = $this->haveId($request,'branchId');
            $branchId = $info->content;
            $roles = $request->input('roles');
            $userId = $request->input('userId');
           
            return $this->addRoleToUserInBranch($branchId,$userId,$roles);
      }
      
      
      // change user status
      public function ChangeBranchUserRequest(Request $request)
      {
            
            $this->validate($request, [
              'userId' => 'required|string',
              'IsAdmin' => 'required|boolean',
              'IsActive' => 'required|boolean'
              ]);
             
            $branchId = $this->haveId($request,'branchId')->content;
            $userId = $request->input('userId');
            $IsActive = $request->input('IsActive');
            $IsAdmin = $request->input('IsAdmin');
            return $this->changeBranchUser($branchId,$userId,$IsAdmin,$IsActive);
      } 

      
      
      


      // update branch by admin
      public function updateBranchRequest(Request $request)
      {
      
        $this->validate($request, [
          'branchId' => 'required|string',
          'name' => 'required|string',
          'location' => 'required|string',
          'type' => 'required|string',
          'IsActive' => 'required|boolean'
          ]);
        
          $companyId = $this->haveId($request,'companyId')->content;
          $name =  $request->input('name');
          $branchId =  $request->input('branchId');
          $location =  $request->input('location');
          $type =  $request->input('type');
          $IsActive =  $request->input('IsActive');
         

        return $this->updateBranch($companyId,$branchId,$name,$location,$type,$IsActive);
      }
  
}
