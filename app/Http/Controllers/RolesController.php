<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RolesController extends Controller
{

    // add role 
    public function addRoleRequest(Request $request )
    {
     $this->validate($request, [
          'name' => 'required',
          'shortName' => 'required',
          'code' => 'required'
          ]);
 
          $name = $request->input('name');
          $shortName = $request->input('shortName');
          $code = $request->input('code');
          $description = $request->input('description');

          return $this->addRole($name, $shortName, $description, $code)
          ;
          
   
    }
 
 
  //   update role
    public function updateRoleRequest(Request $request )
    {
     $this->validate($request, [
          'id' => 'required',
          'shortName' => 'required',
          'code' => 'required',
          'IsActive' => 'required|boolean',
          ]);
 
          $id = $request->input('id');
          $name = $request->input('name');
          $shortName = $request->input('shortName');
          $code = $request->input('code');
          $description = $request->input('description');
          $IsActive = $request->input('IsActive');
         
          return $this->updateRole($id,$name, $shortName, $description, $code,$IsActive);

         
    }
 
 
    //   get role by page
    public function roleByIdRequest(Request $request )
    {

          $id = $request->id;
          return $this->roleById($id);

    }

  //   get role by page
    public function roleByPageRequest(Request $request )
    {

          $page = $request->page; 
          return $this->rolesByPage($page);

    }
 

  //  get role by info and page  
    public function roleByInfoRequest(Request $request)
    {
 
      $this->validate($request, [
          'search' => 'required'
          ]);

      $page = $request->page;
      $search = $request->input('search');
     

      return $this->rolesByInfoAndPage($page,$search);
    

    }
}
