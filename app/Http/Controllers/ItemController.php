<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ItemController extends Controller
{

    // add item withowt unit 
    public function addItemToCompanyRequest(Request $request)
    {
        $this->validate($request, [
            'categoryId' => 'required',
            'name' => 'required',
            'ename' => 'required',
            'commercialName' => 'required',
            'supplier' => 'required',
            ]);
            $search =  $request->input('search');
            $info = $this->checkHeadersCompanyId($request);
            $companyId = $info->content;
            $name = $request->input('name');
            $ename = $request->input('ename');
            $categoryId = $request->input('categoryId');
            $commercialName = $request->input('commercialName');
            $info = $request->input('info');
            $supplier = $request->input('supplier');
            return $this->addNewItem($companyId,$categoryId,$name,$ename,$commercialName,$supplier,$info);
    }


        // add item with unit 
        public function addItemToBranchRequest(Request $request)
        {
            $this->validate($request, [
                'categoryId' => 'required',
                'name' => 'required',
                'ename' => 'required',
                'commercialName' => 'required',
                'supplier' => 'required',
                'quantity' => 'required',
                'baseUnitId' => 'required',
                'showUnitId' => 'required',
                'price' => 'required',
                'unitConversion' => 'required',
                'unitConversion.*' => 'required',
                ]);
                $search =  $request->input('search');
                $info = $this->haveId($request,'branchId');
                $branchId = $info->content;
                $companyId = $this->getBranch($branchId)->original['data']->branch->company_id;
                $name = $request->input('name');
                $ename = $request->input('ename');
                $categoryId = $request->input('categoryId');
                $commercialName = $request->input('commercialName');
                $info = $request->input('info');
                $supplier = $request->input('supplier');
                $unitConversion = $request->input('unitConversion');
                return $this->addNewItem($companyId,$categoryId,$name,$ename,$commercialName,$supplier,$info);
        }
}
