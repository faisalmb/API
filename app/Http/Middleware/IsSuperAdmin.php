<?php

namespace App\Http\Middleware;
use App\Traits\Genralfunction;
use Closure;

class IsSuperAdmin
{
    use Genralfunction;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $appSuperAdminUser = true;
        // $isSuperAdmin = ;
        
        if ( $this->checktoken($request)->IsSuperAdmin != $appSuperAdminUser) {


            $msg = 'you dont have permission to do this action';
            return $this->generalResponse(false,401,$msg, null,null);
        }

        return $next($request);
    }
}
