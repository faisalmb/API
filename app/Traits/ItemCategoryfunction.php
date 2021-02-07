<?php
namespace App\Traits;

use App\Model\itemCategory;
use App\Traits\Genralfunction;

trait ItemCategoryfunction
{
    use Genralfunction;
    use Branchfunction;

    // get itemCategory by id
    public function itemCategoryById($id)
    {
        $itemCategory = itemCategory::where('id',$id)
        ->first();

        if ($itemCategory) {
            return $this->generalResponse(true,200,'success', null,$itemCategory);
        } else {
            return $this->generalResponse(false,404,'itemCategory not found', null,null);
        }
    }

    // add itemCategory function
    public function addItemCategory($companyId,$name, $ename, $info)
    {
        // $companyId = $this->getBranch($branchId)->original['data']->company_id;
        $itemCategory = itemCategory::where('company_id',$companyId)
        ->where('name',$name)
        ->orWhere('ename',$ename)
        ->first();

        if (!$itemCategory) {

            $creat = itemCategory::create(['company_id'=>$companyId,'name'=>$name,'ename'=>$ename,'info'=>$info])->id;
        
            if ($creat) {
            
                return $this->generalResponse(true,200,'success', null,$this->itemCategoryById($creat)->original['data']);
        
            }
        
        } else {
            
            $msg = 'itemCategory exist';
            return $this->generalResponse(false, 409,$msg, null,null);
        
        }
    }


    // update cuntry function
    public function updateItemCategory($id,$companyId,$name, $ename, $info,$IsActive)
    {
        $itemCategory = itemCategory::where('company_id',$companyId)
        ->where('name',$name)
        ->orWhere('ename',$ename)
        ->first();

        if (!$itemCategory) {

            return $this->exeUpdateItemCategory($id,$name, $ename, $info,$IsActive);
        
        } else {

            if ($itemCategory->id == $id) {
                return $this->exeUpdateItemCategory($id,$name, $ename, $info,$IsActive);
            } else {
                $msg = 'itemCategory exist';
            return $this->generalResponse(false, 409,$msg, null,null);
            }
        
        }
    }

   // execute update itemCategory function
   private function exeUpdateItemCategory($id,$name, $ename, $info,$IsActive)
   {
        $creat = itemCategory::where('id',$id)->update(['name'=>$name,'ename'=>$ename,'info'=>$info
        ,'IsActive'=>$IsActive]);
        if ($creat) {
            return $this->generalResponse(true,200,'success', null,$this->itemCategoryById($id)->original['data']);
        } else {
            $msg = 'Cannot create itemCategory';
            return $this->generalResponse(false, 500,$msg, null,null);
        }
   }

   // get itemCategory by page
   public function itemCategoriesByPage($companyId,$page)
   {
       $companyId;
       $page=$page*20;
       $itemCategory = itemCategory::where('company_id',$companyId)
       ->skip($page)
       ->take(20)
       ->get();
      
   
       $response = $this->generalResponse(true,200,'success', null,$itemCategory);
   
       if (count($itemCategory) == 0) {
        $response = $this->generalResponse(false,404,'itemCategory not found', null,null);
       }

       return $response;
   }

    // get itemCategory by info and Page
    public function itemCategoriesByInfoAndPage($companyId,$page,$search)
    {
        $page=$page*20;
        $itemCategory = itemCategory::where('company_id',$companyId)
        ->where(function($q) use ($search) {
            $q->where('name','LIKE',"%".str_ireplace("%20"," ", $search)."%")
              ->orWhere('ename','LIKE',"%".str_ireplace("%20"," ", $search)."%");
              })
        ->skip($page)
        ->take(20)
        ->get();
    
        $response = $this->generalResponse(true,200,'success', null,$itemCategory);
    
        if (count($itemCategory) == 0) {
        $response = $this->generalResponse(false,404,'itemCategory not found', null,null);
        }

        return $response;
    }

    // // add itemCategory to company function
    // public function addItemCategoryToCompany($itemCategoryId, $companyId)
    // {
    //     $itemCategory = itemCategory::select('*')
    //     ->where('itemCategory_id',$itemCategoryId)
    //     ->orWhere('company_id',$companyId)
    //     ->first();
    //     if (!$itemCategory) {

    //         $creat = itemCategory::create(['itemCategory_id'=>$itemCategoryId,'company_id'=>$companyId])->id;
        
    //         if ($creat) {
            
    //             return $this->generalResponse(true,200,'success', null,$this->itemCategoryById($creat)->original['data']);
        
    //         }
        
    //     } else {
            
    //         $msg = 'itemCategory exist';
    //         return $this->generalResponse(false, 409,$msg, null,null);
        
    //     }
    // }


    //  // un active itemCategory for company function
    //  public function unActiveItemCategoryForCompany($itemCategoryId)
    //  {
    //      $itemCategory = itemCategory::select('*')
    //      ->where('id',$itemCategoryId)
    //      ->first();
    //      if ($itemCategory) {
 
    //          $update = itemCategory::where('id',$itemCategoryId)->update(['IsActive'=>false])->id;
         
    //          if ($update) {
             
    //              return $this->generalResponse(true,201,'success', null,null);
         
    //          }
         
    //      } else {
             
    //          $msg = 'itemCategory not exist';
    //          return $this->generalResponse(false, 404,$msg, null,null);
         
    //      }
    //  }

      // get itemCategory in company function
      public function itemCategoryByCompanyId($companyId)
      {
          $itemCategory = itemCategory::select('*')
          ->where('company_id',$companyId)
          ->get();
          if (count($itemCategory) != 0) {
              $responseObj = array();

              foreach ($itemCategory as $value) {
                $responseObj[] = $this->itemCategoryById($value['itemCategory_id'])->original['data'];
              }

                  return $this->generalResponse(true,200,'success', null,$responseObj);
          
          } else {
              
              $msg = 'itemCategory not exist';
              return $this->generalResponse(false, 404,$msg, null,null);
          
          }
      }
}