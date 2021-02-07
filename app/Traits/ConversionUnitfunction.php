<?php
namespace App\Traits;

use App\Model\itemUnitConversion;

trait ConversionUnitfunction
{
    use Genralfunction,Unitfunction;
    
    
    // get Unit Conversion by id 
    public function unitConversionById($id)
    {
        $unitConversion = itemUnitConversion::where('id',$id)
        ->first();

        if ($unitConversion) {
            $baseUnitInfo = $this->unitById($unitConversion->base_unit_id);
            $toUnitInfo = $this->unitById($unitConversion->to_unit_id);
            $responseObj = (object) array (
                'unitConversion' => $unitConversion,
                'baseUnitInfo' => $baseUnitInfo,
                'toUnitInfo' => $toUnitInfo,
            );

            return $this->generalResponse(true,200,'success', null,$unitConversion);
       
        }else {

            return $this->generalResponse(true,404,'not found', null,null);
       
        }
    }

    // add unit conversion
    public function addUnitConversion($itemId, $baseUnitId, $multiplier, $toUnitId)
    {
        $itemUnitConversionId = '';

        $itemUnitConversion = itemUnitConversion::where('item_id',$itemId)
        -> where('base_unit_id',$baseUnitId)
        -> where('multiplier',$multiplier)
        -> where('to_unit_id',$toUnitId)
        -> first();

        if (!$itemUnitConversion) {

            $itemUnitConversionId = itemUnitConversion::create([
                'item_id' => $itemId,'base_unit_id' => $baseUnitId,'multiplier' => $multiplier,'to_unit_id' => $toUnitId,
            ])->id;

        } else {
            $itemUnitConversionId = $itemUnitConversion->id;
        }

        return $itemUnitConversionId;

    }
    
}