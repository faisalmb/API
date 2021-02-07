<?php
namespace App\Traits;

use App\Model\item;
use App\Model\linkingStokWithConversion;
use App\Model\stock;

trait Itemfunction
{

    // get item by id

    public function itemById($id)
    {
       $item = item:: where('id',$id)
       ->first();

       if ($item) {
             return $this->generalResponse(true,200,'success', null,$item);
        }else {
            return $this->generalResponse(true,404,'not found', null,null);
        }
    }

    // add new item 
    public function addNewItem($companyId,$categoryId,$name,$ename,$commercialName,$supplier,$info)
    {
       $item = item::where('company_id',$companyId)
       ->orWhere('name',$name)
       ->orWhere('ename',$ename)
       ->orWhere('commercial_name',$commercialName)
       ->first();

       if (!$item) {
           $itemId = item::create([
            'company_id' => $companyId , 'category_id' => $categoryId ,'name' => $name ,
            'ename' => $ename ,'commercial_name' => $commercialName ,'supplier' => $supplier ,
            'info' => $info 
           ])->id;

           return $this->itemById($itemId);
       } else {

        $msg = 'item exist';
        return $this->generalResponse(false,409,$msg, null,null);

       }
       
    }

    


}