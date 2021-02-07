<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AccountGroupController extends Controller
{

/* master section */

    // add master by sys 
    public function addMasterGroupRequest(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'ename' => 'required|string',
            'tag' => 'required|string|max:20',
            'code' => 'required|string|max:20',
        ]);
       
        $name =  $request->input('name');
        $ename =  $request->input('ename');
        $tage =  $request->input('tag');
        $code =  $request->input('code');

        return $this->addMasterGroup($name,$ename,$tage,$code);
    }


      // update master by sys 
      public function updateMasterGroupRequest(Request $request)
      {
          $this->validate($request, [
              'id' => 'required',
              'name' => 'required|string',
              'ename' => 'required|string',
              'tag' => 'required|string|max:20',
              'code' => 'required|string|max:20',
          ]);
         
          $id =  $request->input('id');
          $name =  $request->input('name');
          $ename =  $request->input('ename');
          $tage =  $request->input('tag');
          $code =  $request->input('code');
  
          return $this->editMasterGroup($id,$name,$ename,$tage,$code);
      }

    // git all master
    public function allMasterGroupRequest(Request $request)
    {
        return $this->allMasterGroup();
    }

    // get master by id
    public function masterGroupByIdRequest(Request $request )
    {
        $id = $request->id;
        return $this->masterGroupById($id);
    }

/* end master section */

 /* -------------------------------------------------------------------- */

/* subset section */
   

    // add master subset in branch  
    public function addMasterSubGroupRequest(Request $request)
    {

        $this->validate($request, [
            'masterId' => 'required',
            // 'parentId' => 'string',
            'name' => 'required|string',
            'ename' => 'required|string',
            'tag' => 'required|string|max:20',
            'code' => 'required|string|max:20',
        ]);
        
        $masterId =  $request->input('masterId');
        // $parentId =  $request->input('parentId');
        $name =  $request->input('name');
        $ename =  $request->input('ename');
        $tage =  $request->input('tag');
        $code =  $request->input('code');

        $branchId = $this->haveId($request,'branchId')->content;

        return $this-> addMasterSubGroup($branchId,$masterId/*,$parentId*/,$name,$ename,$tage,$code);
    }

    // add subset in branch  
    public function addSubGroupRequest(Request $request)
    {

        $this->validate($request, [
            'masterId' => 'required',
            'parentId' => 'required|string',
            'name' => 'required|string',
            'ename' => 'required|string',
            'tag' => 'required|string|max:20',
            'code' => 'required|string|max:20',
        ]);
        
        $masterId =  $request->input('masterId');
        $parentId =  $request->input('parentId');
        $name =  $request->input('name');
        $ename =  $request->input('ename');
        $tage =  $request->input('tag');
        $code =  $request->input('code');

        $branchId = $this->haveId($request,'branchId')->content;

        return $this-> addSubGroup($branchId,$masterId,$parentId,$name,$ename,$tage,$code);
    }

    // edit subset in branch  
    public function editSubGroupRequest(Request $request)
    {

        $this->validate($request, [
            'id' => 'required|string',
            'masterId' => 'required',
            'parentId' => 'required|string',
            'name' => 'required|string',
            'ename' => 'required|string',
            'tag' => 'required|string|max:20',
            'code' => 'required|string|max:20',
        ]);


        $id =  $request->input('id');
        $masterId =  $request->input('masterId');
        $parentId =  $request->input('parentId');
        $name =  $request->input('name');
        $ename =  $request->input('ename');
        $tage =  $request->input('tag');
        $code =  $request->input('code');

        $branchId = $this->haveId($request,'branchId')->content;

        return $this-> editSubGroup($id,$branchId,$masterId,$parentId,$name,$ename,$tage,$code);
    }

    


    // git all master with subset
    public function allMasterWithSubGroupRequest(Request $request)
    {
        $branchId = $this->haveId($request,'branchId')->content;
        return $this->allMasterWithSubGroup($branchId);
    }


    // git all sub with parent
    public function allSubGroupRequest(Request $request,$id)
    {
        $branchId = $this->haveId($request,'branchId')->content;
        return $this->allSubGroup($branchId,$id);
    }




    // Get sub group in branch  by name or ename or tag or cod by master id & paging
    public function GetSubGroupInBranchbyinfoAndMasterIdRequest(Request $request,$page)
    {
            $this->validate($request, [
            'masterId' => 'required',
            'search' => 'required'
            ]);
            $masterId =  $request->input('masterId');
            $search =  $request->input('search');
            $info = $this->haveId($request,'branchId');
            $branchId = $info->content;
            return $this->getSubGroupByMasterInfo($masterId,$search,$branchId,$page);
    } 



    // Get sub group in branch  by name or ename or tag or cod by   paging
    public function GetSubGroupInBranchbyinfoRequest(Request $request,$page)
    {
            $this->validate($request, [
            'search' => 'required'
            ]);
            $search =  $request->input('search');
            $info = $this->haveId($request,'branchId');
            $branchId = $info->content;
            return $this->getSubGroupByInfo($search,$branchId,$page);
    } 

    
  


/* end subset section */
}
