<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ActivityController extends Controller
{
 
       // add activity 
       public function addActivityRequest(Request $request )
       {
        $this->validate($request, [
             'name' => 'required',
             'ename' => 'required'
             ]);
    
             $name = $request->input('name');
             $ename = $request->input('ename');
             $info = $request->input('info');
 
             return $this->addActivity($name, $ename, $info);
             
      
       }
    
    
     //   update activity
       public function updateActivityRequest(Request $request )
       {
        $this->validate($request, [
             'id' => 'required',
             'name' => 'required|string|max:100',
             'ename' => 'required|string|max:100',
             'IsActive' => 'required|boolean',
             ]);
    
             $id = $request->input('id');
             $name = $request->input('name');
             $ename = $request->input('ename');
             $info = $request->input('info');
             $IsActive = $request->input('IsActive');
            
             return $this->updateActivity($id,$name, $ename, $info,$IsActive);
 
            
       }
    
    
       //   get activity by page
       public function activityByIdRequest(Request $request)
       {
 
             $id = $request->id;
             return $this->activityById($id);
 
       }
 
     //   get activity by page
       public function activityByPageRequest(Request $request )
       {

             $page = $request->page;
             return $this->activitiesByPage($page);
 
       }
    
  
     //  get activity by info and page  
       public function activityByInfoRequest(Request $request)
       {
    
         $this->validate($request, [
             'search' => 'required'
             ]);

         $page = $request->page;
         $search = $request->input('search');
        
 
         return $this->activitiesByInfoAndPage($page,$search);
       
 
       }
}
