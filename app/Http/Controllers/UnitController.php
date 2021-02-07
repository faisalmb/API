<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UnitController extends Controller
{

    // add list of unit by sys
    public function addUnitListRequest(Request $request)
    {
        $this->validate($request, [
            'category_id' => 'required',
            'list' => 'required|array|max:10',
            'list.*.name' => 'required|string|max:100',
            'list.*.ename' => 'required|string|max:100',
            ]);

          $categoryId =  $request->input('category_id');
          $list =  $request->input('list');
          
          $result = array();
          foreach ($list as $unit) {
            $result[] = $this-> addUnitList($categoryId,$unit['name'], $unit['ename'], $unit['info']);
          }

          return $this->generalResponse(true, 200,'success', null,$result);
          
    }


    // add unit by sys
    public function addUnitRequest(Request $request)
    {
        $this->validate($request, [
            'category_id' => 'required',
            'name' => 'required|string|max:100',
            'ename' => 'required|string|max:100',
            ]);
  
            $categoryId =  $request->input('category_id');
            $name =  $request->input('name');
            $ename =  $request->input('ename');
            $info =  $request->input('info');
           
            return $this-> addUnit($categoryId,$name, $ename, $info);
          
    }


      // update unit by sys
      public function updateUnitRequest(Request $request)
      {
          $this->validate($request, [
              'id' => 'required',
              'category_id' => 'required',
              'name' => 'required|string|max:100',
              'ename' => 'required|string|max:100',
              ]);

            $id =  $request->input('id');
            $categoryId =  $request->input('category_id');
            $name =  $request->input('name');
            $ename =  $request->input('ename');
            $info =  $request->input('info');
           
            return $this-> updateUnit($id,$categoryId,$name, $ename, $info);
            
      }


      // get unit By Id
      public function unitByIdRequest(Request $request)
      {
            $id = $request->id;
            return $this->unitById($id);
      }


      // get all unit By page
      public function unitByPageRequest(Request $request)
      {
            $page = $request->page;
            return $this-> unitByPage($page);
      }


      // get all unit By page And category Id
      public function unitByCategoryIdAndPageRequest(Request $request)
      {
        $categoryId = $request->categoryId;
        $page = $request->page;
        return $this->  unitByCategoryIdAndPage($categoryId,$page);
      }

     

      // get all unit By page And Info And category Id
      public function unitByPageAndInfoAndCategoryIdRequest(Request $request)
      {
        $this->validate($request, [
          'category_id' => 'required',
          'search' => 'required|string',
          ]);
          
        $page = $request->page;
        $categoryId =  $request->input('category_id');
        $search =  $request->input('search');
        
        return $this-> unitByPageAndInfoAndCategoryId($categoryId,$search,$page);
      }

    // get all unit By page And Info
    public function unitByPageAndInfoRequest(Request $request)
    {
        $this->validate($request, [
        'search' => 'required|string',
        ]);
        $page = $request->page;
        $search =  $request->input('search');
        
        return $this-> unitByPageAndInfo($search,$page);
    }

}
