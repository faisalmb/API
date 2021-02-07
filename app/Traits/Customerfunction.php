<?php
namespace App\Traits;

use App\Model\customer;
use App\Model\customerType;
use App\Model\branchCustomer;
use App\Traits\Genralfunction;

trait Customerfunction
{

    use Genralfunction;

/* customer type section   */  

    // get customer type by id
    public function getCustomerTypeById($id)
    {
        $customerType = customerType::where('id',$id)
        ->first();
        if ($customerType) {
            return $this->generalResponse(true,200,'success', null,$customerType);
        } else {
          return $this->generalResponse(false,404,'customer type not found', null,null);
        }

    }


    // get all customer type 
    public function getAllCustomerType()
    {
        $customerType = customerType::get();
        if ($customerType) {
            return $this->generalResponse(true,200,'success', null,$customerType);
        } else {
          return $this->generalResponse(false,404,'customer type not found', null,null);
        }
        
    }


    // add customer type
   public function addCustomerType($name,$ename,$tag)
   {
       $customerType = customerType::where('tag',$tag)
       ->first();

       if (!$customerType) {
           $id = customerType::create([
            'name' => $name,'ename' => $ename,'tag' => $tag
           ])->id;

           if ($id) {
                return $this->getCustomerTypeById($id);
           } else {
                $msg='internal server error';
                return $this->generalResponse(false,500,$msg, null,null);
           }
           
       } else {
        $msg='customer type exist';
        return $this->generalResponse(false,409,$msg, null,null);
       }
       
   }

    // update customer type
    public function updateCustomerType($id,$name,$ename,$tag)
    {
        $customerType = customerType::where('tag',$tag)
        ->first();

        if (!$customerType) {
            $customer = customerType::where('id', $id)->update([
            'name' => $name,'ename' => $ename,'tag' => $tag
            ]);

            if ($customer) {
                return $this->getCustomerTypeById($id);
            } else {
                $msg='customer updated';
                return $this->generalResponse(false,409,$msg, null,null);
            }
            
        } else if ($customerType->id == $id) {
            $customer = customerType::where('id', $id)->update([
                'name' => $name,'ename' => $ename,'tag' => $tag
                ]);
    
                if ($customer) {
                    return $this->getCustomerTypeById($id);
                } else {
                    $msg='customer updated';
                    return $this->generalResponse(false,409,$msg, null,null);
                }
        } else {
        $msg='customer type exist';
           return $this->generalResponse(false,409,$msg, null,null);
        }
        
    }

/*   end customer type section   */ 

/* ---------------------------------------------------------------------- */

/*    customer section   */   


    // get customer by id
    public function getCustomerById($id)
    {
        $customer = branchCustomer::where('id',$id)
        ->first();
        if ($customer) {
            $type =  $this->getCustomerTypeById($customer->type_id)->original['data'];
                $result = array(
                    'id' => $customer->id,'branch_id' => $customer->branch_id
                    ,'type' => $type,'customer_id' => $customer->customer_id,
                    'phone' => $customer->phone, 'name' => $customer->name,'created_at' => $customer->created_at,
                    'updated_at' => $customer->updated_at
                );
            return $this->generalResponse(true,200,'success', null,$result);
        } else {
            return $this->generalResponse(false,404,'customer not found', null,null);
        }
        
    }
    

    // add customer 
   public function addCustomer($branchId,$phone,$name,$typeId)
   {
       
    $customerId = null;
    $customer = customer::where('phone', $phone)
    ->first();

    $customerType = customerType::where('id',$typeId)
    ->first();
    
    if ($customerType) {
        
        if (!$customer) {
            $id = customer::create(
              ['phone' => $phone]
            )->id;
            $customerId = $id;
        }else {
            $customerId =  $customer->id;
        }

        $branchCustomerExist = branchCustomer::where('customer_id',$customerId)
        ->where('branch_id',$branchId)
        ->first();
        if (!$branchCustomerExist) {

            $id = $this->generateId();
            $branchCustomer = branchCustomer::create([
                'id' => $id,'branch_id' => $branchId,'type_id' => $typeId,'customer_id' => $customerId,
                'phone' => $phone, 'name' => $name
            ])->id;

            if ($branchCustomer) {
                
                return $this->getCustomerById($branchCustomer);
            } else {
                $msg='internal server error';
                return $this->generalResponse(false,500,$msg, null,null);
            }
            

        } else {

            $msg='customer exist';
            return $this->generalResponse(false,409,$msg, null,null);
        }
        
        

    }else {
        $msg='customer type not exist';
        return $this->generalResponse(false,400,$msg, null,null);
    }

   }

    // customer in branch by page and branch id   
   public function getAllCustomerByBranchId($branchId,$page)
   {
        $page = $page *10;
        $branchCustomer = branchCustomer::where('branch_id', $branchId)
        ->skip($page)
        ->take(10)
        ->get();
        $result = array();
        if ($branchCustomer) {
            foreach ($branchCustomer as $customer) {
               
                $result[] = $this->getCustomerById($customer['id'])->original['data'];
                
                
            }
            return $this->generalResponse(true,200,'success', null,$result);
        } else {
            return $this->generalResponse(false,404,'customer not found', null,null);
        }
   }

   // customer in branch  by name or phone & paging   
   public function getCustomerInfo($search,$branchId,$page)
   {
        $page = $page *10;
        $branchCustomer = branchCustomer::where('branch_id',$branchId)
        ->where(function($q) use ($search) {
        $q->where('phone','LIKE',"%".str_ireplace("%20"," ", $search)."%")
            ->orWhere('name','LIKE',"%".str_ireplace("%20"," ", $search)."%");
            })
        ->skip($page)
        ->take(10)
        ->get();

        $result = array();
        if ($branchCustomer) {
            foreach ($branchCustomer as $customer) {
                $customerResult = $this->getCustomerById($customer['id'])->original['data'];
                if ($customerResult) {
                    $result[] =  $customerResult;
                }
            }
            return $this->generalResponse(true,200,'success', null,$result);
        } else {
            return $this->generalResponse(false,404,'customer not found', null,null);
        }
   }



/*   end customer section   */ 

}