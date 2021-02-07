<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CityController extends Controller
{
      
    // add City 
      public function addCityRequest(Request $request )
      {
       $this->validate($request, [
            'name' => 'required',
            'ename' => 'required',
            'stateId' => 'required',
           
            ]);
   
            $name = $request->input('name');
            $ename = $request->input('ename');
            $info = $request->input('info');
            $stateId = $request->input('stateId');

            return $this->addCity($name, $ename, $stateId, $info);
            
     
      }
   
   
    //   update City
      public function updateCityRequest(Request $request )
      {
       $this->validate($request, [
            'id' => 'required',
            'name' => 'required|string|max:100',
            'ename' => 'required|string|max:100',
            'stateId' => 'required',
            'IsActive' => 'required|boolean',
            ]);
   
            $id = $request->input('id');
            $name = $request->input('name');
            $ename = $request->input('ename');
            $info = $request->input('info');
            $stateId = $request->input('stateId');
            $IsActive = $request->input('IsActive');
           
            return $this->updateCity($id,$name, $ename, $stateId, $info,$IsActive);

           
      }
   
   
      //   get City by page
      public function cityByIdRequest(Request $request ,$id)
      {

            return $this->CityById($id);

      }

    //   get City by page
      public function cityByPageRequest(Request $request )
      {
            $stateId = $request->stateId;
            $page = $request->page;
            return $this->citiesByPage($stateId,$page);

      }
   
 
    //  get City by info and page  
      public function CityByInfoRequest(Request $request)
      {
   
        $this->validate($request, [
            'search' => 'required',
            'stateId' => 'required'
            ]);
        $page = $request->page;
        $search = $request->input('search');
        $stateId = $request->input('stateId');
        $page=$page*20;

        return $this->citiesByInfoAndPage($page,$stateId,$search);
      

      }
}
