<?php
namespace App\Traits;

use App\Model\accountMasterGroup;
use App\Model\accountSubGroup;

trait AccountGroupfunction
{

    use Genralfunction;

/* master group section   */ 

    // get master group by id 
    public function masterGroupById($id)
    {
        $masterGroup = accountMasterGroup::where('id',$id)
        ->first();

        if ($masterGroup) {
            return $this->generalResponse(true, 200,'success', null,$masterGroup);
        } else {
            return $this->generalResponse(true, 404,'not found', null,null);
        }
        
    }

    // get all master group in sys
    public function allMasterGroup()
    {
        $masterGroup = accountMasterGroup::get();

        if ($masterGroup) {
            return $this->generalResponse(true, 200,'success', null,$masterGroup);
        } else {
            return $this->generalResponse(true, 404,'not found', null,null);
        }
        
    }

    // add master group to sys by sysadmin
    public function addMasterGroup($name,$ename,$tage,$code)
    {
        $masterGroup = accountMasterGroup::where('tag',$tage)
        ->orWhere('name',$name)
        ->orWhere('ename',$ename)
        ->orWhere('code',$code)
        ->first();

        if (!$masterGroup) {
            $id = accountMasterGroup::create([
                'name' => $name,'ename' => $ename,'tag' => $tage,
                'code' => $code,
            ])->id;

            if ($id) {
                return $this->generalResponse(true, 200,'success', null,$this->masterGroupById($id)->original->data);
               
            } else {
                $msg = 'internal server error';
                return $this->generalResponse(false, 500,$msg, $msg,null);
            }
            
        } else {
            $msg = 'group exist';
            return $this->generalResponse(false, 409,$msg, null,null);
        }
        
    }


    // update master group to sys by sysadmin
    public function editMasterGroup($id,$name,$ename,$tage,$code)
    {
        $masterGroup = accountMasterGroup::where('tag',$tage)
        ->orWhere('name',$name)
        ->orWhere('ename',$ename)
        ->orWhere('code',$code)
        ->first();

        if (!$masterGroup || $masterGroup->id == $id) {
            $update = accountMasterGroup::where('id',$id)->update([
                'name' => $name,'ename' => $ename,'tag' => $tage,
                'code' => $code,
            ]);

            if ($update) {
                return $this->generalResponse(true, 200,'success', null,$this->masterGroupById($id)->original->data);
               
            } else {
                $msg = 'internal server error';
                return $this->generalResponse(false, 500,$msg, $msg,null);
            }
            
        } else {
            $msg = 'group exist';
            return $this->generalResponse(false, 409,$msg, null,null);
        }
        
    }

/* end master group section   */  

/* -----------------------------------------------------------------------------   */  

/* subset group section   */  


    // get sub group by id 
    public function subGroupById($id)
    {
        $accountSubGroup = accountSubGroup::where('id',$id)
        ->first();

        if ($accountSubGroup) {
            return $this->generalResponse(true, 200,'success', null,$accountSubGroup);
        } else {
            return $this->generalResponse(true, 404,'not found', null,null);
        }
        
    }

    // get all master group in branch with sub
    public function allMasterWithSubGroup($branchId)
    {
        $masterGroup = accountMasterGroup::get();

        $masterResult = array();
        if (!empty($masterGroup)) {
           
            foreach ($masterGroup as $master ) {
                $accountSubGroup = accountSubGroup::select('*')
                ->where('master_id',$master['id'])
                ->where('branch_id',$branchId)
                ->where('parent_id',null)
                ->get();
                if (!empty($accountSubGroup)) {
                    $subResult = array();
                    foreach ($accountSubGroup as $sub) {
                        $accountSubGroupCount = accountSubGroup::select('*')
                        ->where('parent_id',$sub['id'])
                        ->count();
                        $result = (object)array(
                            'id' => $sub['id'],
                            'branch_id' => $sub['branch_id'],
                            'parent_id' => $sub['parent_id'],
                            'master_id' => $sub['master_id'],
                            'name' => $sub['name'],
                            'ename' => $sub['ename'], 
                            'tag' => $sub['tag'], 
                            'code' => $sub['code'],
                            'subsetcount' => $accountSubGroupCount, 
                            'created_at' => $sub['created_at'], 
                            'updated_at' => $sub['updated_at']
                        );

                        $subResult[] = $result;
                    }

                    $master = (object)array(
                        'id' => $master['id'],
                        'parent_id' => $master['parent_id'],
                        'master_id' => $master['master_id'],
                        'name' => $master['name'],
                        'ename' => $master['ename'], 
                        'tag' => $master['tag'], 
                        'code' => $master['code'],
                        'subsetcount' => count($subResult),
                        'subset' => $subResult, 
                        'created_at' => $master['created_at'], 
                        'updated_at' => $master['updated_at']
                    );

                    $masterResult[] = $master; 
                    
                }
            }

            return $this->generalResponse(true, 200,'success', $errors = null, $masterResult);
            // return response()->json($masterResult, 200);

        } else {
            return $this->generalResponse(true, 404,'not found', $errors = null, null);
            // return response()->json($masterResult, 404);
        }
        
    }


    // get all sub group in branch with parent id
    public function allSubGroup($branchId,$id)
    {
 
        $accountSubGroup = accountSubGroup::where('branch_id',$branchId)
        ->where('parent_id',$id)
        ->get();
        if (!empty($accountSubGroup)) {
            $subResult = array();
            foreach ($accountSubGroup as $sub) {
                $accountSubGroupCount = accountSubGroup::select('*')
                ->where('parent_id',$sub['id'])
                ->count();
                $result = (object)array(
                    'id' => $sub['id'],
                    'branch_id' => $sub['branch_id'],
                    'parent_id' => $sub['parent_id'],
                    'master_id' => $sub['master_id'],
                    'name' => $sub['name'],
                    'ename' => $sub['ename'], 
                    'tag' => $sub['tag'], 
                    'code' => $sub['code'],
                    'subsetcount' => $accountSubGroupCount, 
                    'created_at' => $sub['created_at'], 
                    'updated_at' => $sub['updated_at']
                );

                $subResult[] = $result;
            }

            return $this->generalResponse(true, 200,'success', $errors = null, $subResult);
           

        } else {
            
            return $this->generalResponse(true, 404,'not found', $errors = null, null);
           
        }
        
    }

    // add master sub group to branch
    public function addMasterSubGroup($branchId,$masterId/*,$parentId*/,$name,$ename,$tage,$code)
    {
        $accountSubGroup = accountSubGroup::where('branch_id',$tage)
        ->where('tag',$tage)
        ->orWhere('name',$name)
        ->orWhere('ename',$ename)
        ->orWhere('code',$code)
        ->first();

        if (!$accountSubGroup) {
            $subGroupId = $this->generateId();
            $id = accountSubGroup::create([
                'id'=>$subGroupId,'branch_id' => $branchId,'master_id' => $masterId,/*'parent_id' => $parentId,*/
                'name' => $name,'ename' => $ename,'tag' => $tage,
                'code' => $code,
            ])->id;

            if ($id) {
                return $this->generalResponse(true, 200,'success', $errors = null, $this->subGroupById($id)->original->data);
            } else {
                $msg = 'internal server error';
                return $this->generalResponse(false, 500,$msg, $msg,null);
            }
            
        } else {
            $msg = 'group exist';
            return $this->generalResponse(false, 409,$msg, null,null);
        }
        
    }



     // add  sub group to branch
     public function addSubGroup($branchId,$masterId,$parentId,$name,$ename,$tage,$code)
     {
         $accountSubGroup = accountSubGroup::select('*')
         ->where('branch_id',$branchId)
         ->where('tag',$tage)
         ->orWhere('name',$name)
         ->orWhere('ename',$ename)
         ->orWhere('code',$code)
         ->first();
 
         if (!$accountSubGroup) {
             $subGroupId = $this->generateId();
             $id = accountSubGroup::create([
                 'id'=>$subGroupId,'branch_id' => $branchId,'master_id' => $masterId,'parent_id' => $parentId,
                 'name' => $name,'ename' => $ename,'tag' => $tage,
                 'code' => $code,
             ])->id;
 
             if ($id) {
                return $this->generalResponse(true, 200,'success', $errors = null, $this->subGroupById($id)->original->data);
             } else {
                 $msg = 'internal server error';
                 return $this->generalResponse(false, 500,$msg, $msg,null);
             }
             
         } else {
             $msg = 'group exist';
             return $this->generalResponse(false, 409,$msg, null,null);
         }
         
     }


     // edit  sub group to branch
     public function editSubGroup($id,$branchId,$masterId,$parentId,$name,$ename,$tage,$code)
     {
         $accountSubGroup = accountSubGroup::select('*')
         ->where('branch_id',$branchId)
         ->where('tag',$tage)
         ->orWhere('name',$name)
         ->orWhere('ename',$ename)
         ->orWhere('code',$code)
         ->first();
 
         if (!$accountSubGroup || $accountSubGroup->id == $id ) {
             
             $update = accountSubGroup::where('id',$id)->update([
                 'master_id' => $masterId,'parent_id' => $parentId,
                 'name' => $name,'ename' => $ename,'tag' => $tage,
                 'code' => $code,
             ]);
 
             if ($update) {
                return $this->generalResponse(true, 200,'success', $errors = null, $this->subGroupById($id)->original->data);
                //  return response()->json($this->subGroupById($id)->original, 200);
             } else {
                 $msg = 'internal server error';
                 return $this->generalResponse(false, 500,$msg, $update,null);
            
             }
             
         } else {
             $msg = 'group exist';
             return $this->generalResponse(false, 409,$msg, null,null);
         }
         
     }


    // sub group in branch  by name or ename or tag or code & paging & master id   
    public function getSubGroupByMasterInfo($masterId,$search,$branchId,$page)
    {
            $page = $page *10;
            $accountSubGroup = accountSubGroup::select('*')
            ->where('master_id',$masterId)
            ->where('branch_id',$branchId)
            ->where(function($q) use ($search) {
            $q->where('ename','LIKE',"%".str_ireplace("%20"," ", $search)."%")
                ->orWhere('tag','LIKE',"%".str_ireplace("%20"," ", $search)."%")
                ->orWhere('code','LIKE',"%".str_ireplace("%20"," ", $search)."%")
                ->orWhere('name','LIKE',"%".str_ireplace("%20"," ", $search)."%");
                })
            ->skip($page)
            ->take(10)
            ->get();

            if (!empty($accountSubGroup) && count($accountSubGroup)>0) {
                return $this->generalResponse(true, 200,'success', null,$accountSubGroup);
            } else {
                return $this->generalResponse(true, 404,'not found', null,null);
            }
            
    }

    


    // sub group in branch  by name or ename or tag or code & paging  
    public function getSubGroupByInfo($search,$branchId,$page)
    {
            $page = $page *10;
            $accountSubGroup = accountSubGroup::select('*')
            ->where('branch_id',$branchId)
            ->where(function($q) use ($search) {
            $q->where('ename','LIKE',"%".str_ireplace("%20"," ", $search)."%")
                ->orWhere('tag','LIKE',"%".str_ireplace("%20"," ", $search)."%")
                ->orWhere('code','LIKE',"%".str_ireplace("%20"," ", $search)."%")
                ->orWhere('name','LIKE',"%".str_ireplace("%20"," ", $search)."%");
                })
            ->skip($page)
            ->take(10)
            ->get();

            if (!empty($accountSubGroup) && count($accountSubGroup)>0) {
                return $this->generalResponse(true, 200,'success', null,$accountSubGroup);
            } else {
                return $this->generalResponse(true, 404,'not found', null,null);
            }
            
    }

/* end subset group  section  */  



}