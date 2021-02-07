<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class ItemCategoryController extends Controller
{

    // add ItemCategory by company id
    public function addItemCategoryByCompanyIdRequest(Request $request )
    {
     $this->validate($request, [
          'name' => 'required',
          'ename' => 'required'
          ]);
          $info = $this->checkHeadersCompanyId($request);
          $companyId = $info->content;
          $name = $request->input('name');
          $ename = $request->input('ename');
          $info = $request->input('info');

          return $this->addItemCategory($companyId,$name, $ename, $info);
          
   
    }


     // add ItemCategory by branch id
     public function addItemCategoryByBranchIdRequest(Request $request )
     {
      $this->validate($request, [
           'name' => 'required',
           'ename' => 'required'
           ]);
           $info = $this->haveId($request,'branchId');
           $branchId = $info->content;
           $companyId = $this->getBranch($branchId)->original['data']->branch->company_id;
         
           $name = $request->input('name');
           $ename = $request->input('ename');
           $info = $request->input('info');
 
           return $this->addItemCategory($companyId,$name, $ename, $info);
           
    
     }
 
 
  //   update Item Category By Company Id
    public function updateItemCategoryByCompanyIdRequest(Request $request )
    {
     $this->validate($request, [
          'id' => 'required',
          'name' => 'required|string|max:100',
          'ename' => 'required|string|max:100',
          'IsActive' => 'required|boolean',
          ]);
 
          $id = $request->input('id');
          $info = $this->checkHeadersCompanyId($request);
          $companyId = $info->content;
          $name = $request->input('name');
          $ename = $request->input('ename');
          $info = $request->input('info');
          $IsActive = $request->input('IsActive');
         
          return $this->updateItemCategory($id,$companyId,$name, $ename, $info,$IsActive);

         
    }


    //   update Item Category By Branch Id
    public function updateItemCategoryByBranchIdRequest(Request $request )
    {
     $this->validate($request, [
          'id' => 'required',
          'name' => 'required|string|max:100',
          'ename' => 'required|string|max:100',
          'IsActive' => 'required|boolean',
          ]);
 
          $id = $request->input('id');
          $info = $this->haveId($request,'branchId');
          $branchId = $info->content;
          $companyId = $this->getBranch($branchId)->original['data']->branch->company_id;
          $name = $request->input('name');
          $ename = $request->input('ename');
          $info = $request->input('info');
          $IsActive = $request->input('IsActive');
         
          return $this->updateItemCategory($id,$companyId,$name, $ename, $info,$IsActive);

         
    }
 
 
 
    //   get ItemCategory by page
    public function itemCategoryByIdRequest(Request $request)
    {

          $id = $request->id;
          return $this->itemCategoryById($id);

    }

  //   get ItemCategory by Company Id And page
    public function itemCategoryByCompanyIdAndPageRequest(Request $request )
    {
          $info = $this->checkHeadersCompanyId($request);
          $companyId = $info->content;
          $page = $request->page;
          return $this->itemCategoriesByPage($companyId,$page);

    }

    //   get ItemCategory by branch Id And page
    public function itemCategoryByBranchIdAndPageRequest(Request $request )
    {
          $info = $this->haveId($request,'branchId');
          $branchId = $info->content;
          $companyId = $this->getBranch($branchId)->original['data']->branch->company_id;
          $page = $request->page;
          return $this->itemCategoriesByPage($companyId,$page);

    }
 

    //  get ItemCategory by Company Id And info and page  
    public function itemCategoryByCompanyIdAndInfoRequest(Request $request)
    {
 
      $this->validate($request, [
          'search' => 'required'
          ]);

      $info = $this->checkHeadersCompanyId($request);
      $companyId = $info->content;
      $page = $request->page;
      $search = $request->input('search');
     

      return $this->itemCategoriesByInfoAndPage($companyId,$page,$search);
    

    }

  //  get ItemCategory by branch Id And info and page  
    public function itemCategoryByBranchIdAndInfoRequest(Request $request)
    {
 
      $this->validate($request, [
          'search' => 'required'
          ]);
          
      $info = $this->haveId($request,'branchId');
      $branchId = $info->content;
      $companyId = $this->getBranch($branchId)->original['data']->branch->company_id;
      $page = $request->page;
      $search = $request->input('search');
     

      return $this->itemCategoriesByInfoAndPage($companyId,$page,$search);
    

    }
}
