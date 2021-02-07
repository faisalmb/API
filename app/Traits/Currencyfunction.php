<?php

namespace App\Traits;

use App\Model\currency;
use App\Model\companyCurrencies;

trait Currencyfunction
{

  use Genralfunction ;
    //add Currency function
   public function addCurrency($name,$shortname,$country)
   {
      $currency = currency::select('*')
      ->where('name', $name)
      ->orWhere('shortname', $shortname)
      ->orWhere('country', $country)
      ->first();
      if (!$currency) {
         $result = currency::create(
           ['name' => $name,'shortname' => $shortname,'country' => $country
           ]
         )->id;

         if ($result) {
          $currencyInfo = array('id' => $result,'name' => $name,'shortname' => $shortname,
          'country' => $country);
          
          return $this->generalResponse(true,200,'success', null,$currencyInfo);

         }else {
          return response()->json('internal server error', 500);
          $msg = 'internal server error';
          return $this->generalResponse(false,500,$msg, null,null);
         }
        
       } else {
         $msg = 'currency already exists';
         return $this->generalResponse(false,409,$msg, null,null);
       }
   }

       // get Currency by id
  public function getCurrency($id)
  {
        $currency = currency::select('*')
        ->where('id', $id)
        ->first();
        if ($currency) {
          return $this->generalResponse(true,200,'success', null,$currency);
        } else {
          return $this->generalResponse(false,404,'currency not found', null,null);
        }

  }

 // update currency
  public function updateCurrency($id,$name,$shortname,$country)
  {
    
    $currency = currency::select('*')
    ->where('name', $name)
    ->where('shortname', $shortname)
    ->where('country', $country)
    ->first();

    if ($currency) {
      if ($currency->id == $id) {
        $msg =  'is already updated' ;
      } else {
        $msg = 'this currency already registered';
      }

      return $this->generalResponse(false,409,$msg, null,null);

    } else {
          return $this->exeUpdateCurrency($id,$name,$shortname,$country);
    }
  }

   // Update user function
    public function exeUpdateCurrency($id,$name,$shortname,$country)
    {

        $currency= currency::where('id', $id)->update(['name' => $name,'shortname' => $shortname, 'country' => $country
        ]);

        if ($currency) {
            return $this-> getCurrency($id);
        } else {
            $msg = 'is already updated' ;
            return $this->generalResponse(false,409,$msg, null,null);
        }

    }


    // get Currencies by Page 
    public function getCurrenciesByPage($page)
    {
            $page = $page *10;
            $currency = currency::select('*')
            ->skip($page)
            ->take(10)
            ->get();
        
            if (count($currency) != 0) {
              return $this->generalResponse(true,200,'success', null,$currency);
            } else {
              return $this->generalResponse(false,404,'currency not found', null,null);
            }

    }

    // add Currency To Company
    public function addCurrencyToCompany($companyId,$currencyId)
    {
        
        $companyCurrencies = companyCurrencies::select('*')
        ->where('company_id', $companyId)
        ->where('currency_id', $currencyId)
        ->first();
        
        if (!$companyCurrencies) {
            
            $result = companyCurrencies::create(
            ['company_id' => $companyId,'currency_id' => $currencyId]);
   
            return $this-> getCurrency($currencyId);
            
        } else {
            $msg = 'currency already exists';
            return $this->generalResponse(false,409,$msg, null,null);
        }

    }

    // Get Currency In Company
  public function GetCurrencyInCompany($companyId)
  {
      
        $companyCurrencies = companyCurrencies::select('currency_id')
        ->where('company_id',$companyId)
        ->get();
        $result = array();
        if ($companyCurrencies) {
           foreach ($companyCurrencies as $key ) {
            
              $result[] = $this->getCurrency($key['currency_id'])->original['data'];
            
           }
          return $this->generalResponse(true,200,'success', null,$result);
        } else {
          return $this->generalResponse(false,404,'currency not found', null,null);
        }

  }
  
}