<?php
namespace App\Traits;

use App\Model\stock;
use App\Model\linkingStokWithConversion;

trait Stockfunction
{
    use Genralfunction;


    // get linking Stok With Conversion by id 
    public function linkingStokWithConversion($stockId)
    {
        $stockConversion = linkingStokWithConversion::where('stock_id',$stockId)
        ->get();

        if (count($stockConversion) != 0) {
            
            return $this->generalResponse(true,200,'success', null,$stockConversion);
        }else {
            return $this->generalResponse(true,404,'not found', null,null);
        }
    }

    // Linking Stok With Conversion
    public function addLinkingStokWithConversion($stockId,$conversionId)
    { 
        $linkingStokWithConversionId = '';

        $linking = linkingStokWithConversion::where('stock_id',$stockId)
        ->where('conversions_id',$conversionId)
        ->first();

        if ($linking) {
            $linkingStokWithConversionId =$linking->id;
        } else {

            $linkingStokWithConversionId = linkingStokWithConversion::create([
                'stock_id'=>$stockId,'conversions_id'=>$conversionId
            ])->id;
        }

        return $linkingStokWithConversionId;

    }

    // get stock by id 
    public function getStockById($id)
    {
        $stock = stock::where('id',$id)
        ->first();

        if ($stock) {
            return $this->generalResponse(true,200,'success', null,$stock);
        } else {
            return $this->generalResponse(false,404,'stock not found', null,null);
        }
    }
     // add item to branch stock
     public function addNewItemToStock($branchId, $itemId, $quantity, $baseUnitId, $showUnitId, $price)
     {
         $stock = stock::where('branch_id',$branchId)
         ->where('item_id',$itemId)
         ->first();

         if (!$stock) {

            $addNewItemToStockId = stock::create([
                'branch_id'=>$branchId,'item_id'=>$itemId
                ,'quantity'=>$quantity,'base_unit_id'=>$baseUnitId
                ,'show_unit_id'=>$showUnitId,'price'=>$price
            ])->id;

            return $this->getStockById($addNewItemToStockId);

         } else {
             
             $msg = 'item exist';
             return $this->generalResponse(false,409,$msg, null,null);
       
         }
         
         
     }
}