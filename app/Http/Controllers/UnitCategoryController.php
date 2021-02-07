<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UnitCategoryController extends Controller
{


    // add list of category by sys
    public function addUnitCategoryListRequest(Request $request)
    {
        $this->validate($request, [
            'list' => 'required|array|max:10',
            'list.*.name' => 'required|string|max:100',
            'list.*.ename' => 'required|string|max:100',
            ]);
          $list =  $request->input('list');
          
          $result = array();
          foreach ($list as $category) {
            $result[] = $this-> addUnitCategory($category['name'], $category['ename'], $category['info']);
          }

          return $this->generalResponse(true, 200,'success', null,$result);
          
    }


    // add category by sys
    public function addUnitCategoryRequest(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:100',
            'ename' => 'required|string|max:100',
            ]);

  
         
            $name =  $request->input('name');
            $ename =  $request->input('ename');
            $info =  $request->input('info');
           
            return $this-> addUnitCategory($name, $ename, $info);
          
    }


      // update category by sys
      public function updateUnitCategoryRequest(Request $request)
      {
          $this->validate($request, [
              'id' => 'required',
              'name' => 'required|string|max:100',
              'ename' => 'required|string|max:100',
              ]);

            $id =  $request->input('id');
            $name =  $request->input('name');
            $ename =  $request->input('ename');
            $info =  $request->input('info');
           
            return $this-> updateUnitCategory($id,$name,$ename,$info);
            
      }


      // get category By Id
      public function categoryByIdRequest(Request $request)
      {
            $id = $request->id;
            return $this-> categoryById($id);
      }


      // get all category By page
      public function categoryByPageRequest(Request $request)
      {
            $page = $request->page;
            return $this-> categoryByPage($page);
      }


      // get all category By page And Info
      public function categoryByPageAndInfoRequest(Request $request)
      {
        $this->validate($request, [
          'search' => 'required|string',
          ]);
        $page = $request->page;
        $search =  $request->input('search');
        
        return $this-> categoryByPageAndInfo($search,$page);
      }

}
