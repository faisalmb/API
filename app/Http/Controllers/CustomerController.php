<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CustomerController extends Controller
{

/* customer type section   */  

    // add customer to branch

    public function addCustomerTypeRequest(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'ename' => 'required|string',
            'tag' => 'required|string|max:4',
        ]);
       
        $name =  $request->input('name');
        $ename =  $request->input('ename');
        $tag =  $request->input('tag');

        return $this->addCustomerType($name,$ename,$tag);

    }

    // customer type by id

    public function getCustomerTypeByIdRequest(Request $request)
    {
        $id = $request->id;
        return $this->getCustomerTypeById($id);
    }

    // customer type by id

    public function getAllCustomerTypeRequest(Request $request)
    {
        return $this->getAllCustomerType();
    }

/*   end customer type section   */ 

/* ---------------------------------------------------------------------- */

/*    customer section   */   
    
    // add customer type to sys

    public function addCustomerRequest(Request $request)
    {
        $this->validate($request, [
            'typeId' => 'required|string',
            'phone' => 'required|min:4|max:9',
            'name' => 'required|string',
        ]);
        $info = $this->haveId($request,'branchId');
        $branchId = $info->content;
        $typeId =  $request->input('typeId');
        $phone =  $request->input('phone');
        $name =  $request->input('name');

        return $this->addCustomer($branchId,$phone,$name,$typeId);

    }

    // customer by id

    public function getCustomerByIdRequest(Request $request)
    {
        $id = $request->id;
        return $this->getCustomerById($id);
    }


     // all customer by branchId & page

     public function getAllCustomerByBranchIdRequest(Request $request)
     {    
         $page = $request->page;  
         $info = $this->haveId($request,'branchId');
         $branchId = $info->content;
         return $this->getAllCustomerByBranchId($branchId,$page);
     }


    // Get customer in branch  by name or phone  paging
    public function GetCustomerInBranchbyinfoRequest(Request $request)
    {
            $this->validate($request, [
            'search' => 'required'
            ]);
            $page = $request->page; 
            $search =  $request->input('search');
            $info = $this->haveId($request,'branchId');
            $branchId = $info->content;
            return $this->getCustomerInfo($search,$branchId,$page);
    } 



/*   end customer section   */ 

}
