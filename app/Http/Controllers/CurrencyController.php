<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CurrencyController extends Controller
{

    // add currency
    public function addCurrencyBySuperAdminRequest(Request $request)
    {
        $this->validate($request, [
          'name' => 'required|string',
          'shortname' => 'required|string',
          'country' => 'required|string',
          ]);
        $name = $request->input('name');
        $shortname =  $request->input('shortname');;
        $country =  $request->input('country');      
        return $this->addCurrency($name,$shortname,$country);
    }


    // update currency 
    public function updateCurrencyRequest(Request $request)
    {
    
    $this->validate($request, [
        'id' => 'required|string',
        'name' => 'required|string',
        'shortname' => 'required|string',
        'country' => 'required|string',
        ]);
        
        $id =  $request->input('id');
        $name = $request->input('name');
        $shortname =  $request->input('shortname');;
        $country =  $request->input('country'); 

    return $this->updateCurrency($id,$name,$shortname,$country);
    }

    // add currency to company
    public function addCurrencyToCompanyRequest(Request $request)
    {
          $this->validate($request, [
            'currency_id' => 'required|string'
            ]);
          $companyId = $this->haveId($request,'CompanyId')->content;
          $currencyId = $request->input('currency_id');
          
          return $this->addCurrencyToCompany($companyId,$currencyId);
    }

     // Get Currency by Id
     public function getCurrencyByIdRequest(Request $request,$id)
     {
           return $this->getCurrency($id);
     } 

    // Get Currencies by paging
    public function getCurrenciesByPageRequest(Request $request)
    {
            $page = $request->page;
            return $this->getCurrenciesByPage($page);
    } 

    // Get Currencies in company
    public function GetCurrencyInCompanyRequest(Request $request)
    {
        $info = $this->haveId($request,'CompanyId');
        $companyId = $info->content;
        return $this->GetCurrencyInCompany($companyId);
    } 

    

}
