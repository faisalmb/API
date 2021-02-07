<?php

namespace App\Http\Middleware;

use App\Model\role;
use App\Traits\Genralfunction;
use Closure;
use App\Model\branchUser;
use App\Model\branchUserRole;
use Symfony\Component\Mime\Message;

class HaveRole
{
    use Genralfunction;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next,$role)
    {
        $isActive = false;
        $isAdmin = false;
        $userRoleId = null;
        $userId = $this->checktoken($request)->id;
        $branchId = $request->input('branchId');
        if (!empty($request->headers->get('branchId'))) {
            $branchId = $request->headers->get('branchId');
        }
        
        
        $branchUser = branchUser::where('user_id', $userId)
        ->where('branch_id', $branchId)
        ->first();
        if ($branchUser) {
            $isActive = $branchUser->IsActive;
            $isAdmin = $branchUser->IsAdmin;  
            $userRoleId = $branchUser->id;
        }
        
        if (($isActive == true && !empty($userId) && !empty($branchId) && !empty($userRoleId)) || $isAdmin )  {
            $roleStatus = role::select('*')
            ->where('code', $role)
            ->orWhere('short_name', $role)
            ->first();
            if ($roleStatus) {
               
                $branchUserRole = branchUserRole::select('*')
                ->where('role_id', $roleStatus->id)
                ->where('branch_user_id', $userRoleId)
                ->first();
                if ($branchUserRole || $isAdmin) {
                    return $next($request);
                }else{
                   
                    $msg = "you don't have permission to perform this action";
        
                    return $this->generalResponse(false,401,$msg, null,null);
                }
            }else {
               
                $msg = "role does not exist ";
    
                return $this->generalResponse(false,401,$msg, null,null);
            }

        }else {
           
            $msg = "branchId required , or user in not active , or role does not exist ";

            return $this->generalResponse(false,401,$msg, null,null);
        }
        
       
    }
}
