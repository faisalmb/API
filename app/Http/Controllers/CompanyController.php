<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */


     public function addCompanyByUserRequest(Request $request)
     {
         $this->validate($request, [
           'primaryPhone' => 'required|min:4',
           'name' => 'required|string',
           'countryId' => 'required',
           'stateId' => 'required',
           'cityId' => 'required',
           'address' => 'required|string',
           'taxNumber' => 'required|string',
           'activityId' => 'required|string',
           ]);
         $info = $this->checktoken($request);
         $userId =  $info->id;
         $name =  $request->input('name');
         $countryId =  $request->input('countryId');
         $stateId =  $request->input('stateId');
         $cityId =  $request->input('cityId');
         $address =  $request->input('address');
         $taxNumber =  $request->input('taxNumber');
         $primaryPhone =  $request->input('primaryPhone'); 
         $activityId  =  $request->input('activityId');        
         return $this->addCompanyByUser($userId,$name,$countryId,$stateId,$cityId,$address,$taxNumber,$primaryPhone,$activityId);
     }

     public function addCompanyBySysAdminRequest(Request $request)
     {
         $this->validate($request, [
           'primaryPhone' => 'required|min:4|max:9',
           'name' => 'required|string',
           'countryId' => 'required|string',
           'stateId' => 'required|string',
           'cityId' => 'required|string',
           'address' => 'required|string',
           'taxNumber' => 'required|string',
           'adminId' => 'required|string',
           'activityId' => 'required|string',
           ]);
         $info = $this->checktoken($request);
         $userId =  $info->id;
         $name =  $request->input('name');
         $countryId =  $request->input('countryId');
         $stateId =  $request->input('stateId');
         $cityId =  $request->input('cityId');
         $address =  $request->input('address');
         $taxNumber =  $request->input('taxNumber');
         $primaryPhone =  $request->input('primaryPhone');
         $adminId =  $request->input('adminId'); 
         $activityId  =  $request->input('activityId');        
         return $this->addCompanyBySysAdmin($adminId,$userId,$name,$countryId,$stateId,$cityId,$address,$taxNumber,$primaryPhone,$activityId);
     }


    // Get companies  by   paging
    public function getCompaniesByPageRequest(Request $request)
      {
            $page = $request->page;
            return $this->getCompaniesByPage($page);
      } 


    // Get companies  by   paging
      public function getMyCompaniesByPageRequest(Request $request)
      {
            $page = $request->page;
            $userId = $this->checktoken($request)->id;
            return $this->getMyCompaniesByPage($page,$userId);
      } 

      // Get Companies That I Work For It by paging
      public function getCompaniesThatIWorkForItByPageRequest(Request $request)
      {
            $page = $request->page;
            $userId = $this->checktoken($request)->id;
            return $this->getCompaniesThatIWorkForItByPage($page,$userId);
      } 


      // Get user  by name or phone  paging
      public function GetUserInCompanybyinfoRequest(Request $request)
      {
            $this->validate($request, [
              'search' => 'required'
              ]);
            $page = $request->page;
            $search =  $request->input('search');
            $info = $this->checkHeadersCompanyId($request);
            $companyId = $info->content;
            return $this->getuserInfoCompany($search,$companyId,$page);
      } 


      // Get user in company  by  paging
      public function GetUserInCompanyRequest(Request $request)
      {
            $page = $request->page;
            $info = $this->checkHeadersCompanyId($request);
            $companyId = $info->content;
            return $this->getMyCompanyUserByPage($page,$companyId);
      } 

      // add user to company
      public function AddCompanyUserRequest(Request $request)
      {
           
            $this->validate($request, [
              'userId' => 'required|string',
              'IsAdmin' => 'required|boolean',
              'IsActive' => 'required|boolean'
              ]);
            $companyId = $this->checkHeadersCompanyId($request)->content;
            $userId = $request->input('userId');
            $IsActive = $request->input('IsActive');
            $IsAdmin = $request->input('IsAdmin');
            return $this->addCompanyUser($companyId,$userId,$IsAdmin,$IsActive);
      }
      
      
      // add user to company
      public function ChangeCompanyUserRequest(Request $request)
      {
            
            $this->validate($request, [
              'userId' => 'required|string',
              'IsAdmin' => 'required|boolean',
              'IsActive' => 'required|boolean'
              ]);
            $companyId = $this->checkHeadersCompanyId($request)->content;
            $userId = $request->input('userId');
            $IsActive = $request->input('IsActive');
            $IsAdmin = $request->input('IsAdmin');
            return $this->changeCompanyUser($companyId,$userId,$IsAdmin,$IsActive);
      } 

      
      
      


      // update company by admin
      public function updateCompanyRequest(Request $request)
      {
        $info = $this->checkHeadersCompanyId($request);
        $this->validate($request, [
          'name' => 'required|string',
           'countryId' => 'required|string',
           'stateId' => 'required|string',
           'cityId' => 'required|string',
           'address' => 'required|string',
           'taxNumber' => 'required|string',
          ]);
        
          $companyId =  $info->content;
          $name =  $request->input('name');
          $countryId =  $request->input('countryId');
          $stateId =  $request->input('stateId');
          $cityId =  $request->input('cityId');
          $address =  $request->input('address');
          $taxNumber =  $request->input('taxNumber');

        return $this->updateCompany($companyId,$name,$countryId,$stateId,$cityId,$address,$taxNumber);
      }
  
     

}
