<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CountryController extends Controller
{
    // add country 
      public function addCountryRequest(Request $request )
      {
       $this->validate($request, [
            'name' => 'required',
            'ename' => 'required',
            'code' => 'required',
            'phoneCode' => 'required',
           
            ]);
   
            $name = $request->input('name');
            $ename = $request->input('ename');
            $code = $request->input('code');
            $phoneCode = $request->input('phoneCode');

            return $this->addCountry($name, $ename, $code, $phoneCode);
            
     
      }
   
   
    //   update country
      public function updateCountryRequest(Request $request )
      {
       $this->validate($request, [
            'id' => 'required',
            'name' => 'required|string|max:100',
            'ename' => 'required|string|max:100',
            'code' => 'required|string|max:6',
            'phoneCode' => 'required|string|max:6',
            'IsActive' => 'required|boolean',
            ]);
   
            $id = $request->input('id');
            $name = $request->input('name');
            $ename = $request->input('ename');
            $code = $request->input('code');
            $phoneCode = $request->input('phoneCode');
            $IsActive = $request->input('IsActive');
           
            return $this->updateCountry($id,$name, $ename, $code, $phoneCode,$IsActive);

           
      }
   
   
      //   get country by page
      public function countriesByIdRequest(Request $request )
      {

            $id = $request->id;
            return $this->countryById($id);

      }

    //   get country by page
      public function countriesByPageRequest(Request $request )
      {

            $page = $request->page;
            return $this->countriesByPage($page);

      }
   
 
    //  get country by info and page  
      public function countryByInfoRequest(Request $request)
      {
   
        $this->validate($request, [
            'search' => 'required'
            ]);
        $page = $request->page;
        $search = $request->input('search');
        return $this->countriesByInfoAndPage($page,$search);
      

      }

}
