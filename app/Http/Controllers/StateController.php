<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StateController extends Controller
{
      
    // add State 
      public function addStateRequest(Request $request )
      {
       $this->validate($request, [
            'name' => 'required',
            'ename' => 'required',
            'countryId' => 'required',
           
            ]);
   
            $name = $request->input('name');
            $ename = $request->input('ename');
            $info = $request->input('info');
            $countryId = $request->input('countryId');

            return $this->addState($name, $ename, $countryId, $info);
            
     
      }
   
   
    //   update State
      public function updateStateRequest(Request $request )
      {
       $this->validate($request, [
            'id' => 'required',
            'name' => 'required|string|max:100',
            'ename' => 'required|string|max:100',
            
            'countryId' => 'required',
            'IsActive' => 'required|boolean',
            ]);
   
            $id = $request->input('id');
            $name = $request->input('name');
            $ename = $request->input('ename');
            $info = $request->input('info');
            $countryId = $request->input('countryId');
            $IsActive = $request->input('IsActive');
           
            return $this->updateState($id,$name, $ename, $countryId, $info,$IsActive);

           
      }
   
   
      //   get State by page
      public function statesByIdRequest(Request $request )
      {

            $id = $request->id;
            return $this->StateById($id);

      }

    //   get State by page
      public function statesByPageRequest(Request $request )
      {
            $countryId = $request->countryId;
            $page = $request->page;
            return $this->statesByPage($countryId,$page);

      }
   
 
    //  get State by info and page  
      public function StateByInfoRequest(Request $request)
      {
   
        $this->validate($request, [
            'search' => 'required',
            'countryId' => 'required'
            ]);
        $page = $request->page;
        $search = $request->input('search');
        $countryId = $request->input('countryId');
        $page=$page*20;

        return $this->statesByInfoAndPage($page,$countryId,$search);
      

      }
}
