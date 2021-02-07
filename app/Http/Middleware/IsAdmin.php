<?php

namespace App\Http\Middleware;
use App\Traits\Genralfunction;
use Closure;
use App\Model\companyUser;
use App\Model\user;

class IsAdmin
{
    use Genralfunction;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next ,$user )
    {
        $isActive = false;
        $isAdmin = false;
        $userId = $this->checktoken($request)->id;
        $companyId = $this->checkHeadersCompanyId($request)->content;
        $companyUser = companyUser::select('*')
        ->where('user_id', $userId)
        ->where('company_id', $companyId)
        ->first();
        if ($companyUser) {

            $isActive = $companyUser->IsActive;
            $isAdmin = $companyUser->IsAdmin;  

        }

        
        if ($isActive != true || ($isAdmin != true && $user != false) )  {
            $msg = 'you dont have permission to do this action';
            return $this->generalResponse(false,401,$msg, null,null);
        }

        return $next($request);
    }
}
