<?php

namespace App\Http\Middleware;
use App\Traits\Genralfunction;
use Closure;

class Admin
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
        $appAdminUser = 1;
        $appSuperAdminUser = 3 ;

        
        if ($this->checktoken($request)->type != $appAdminUser && $this->checktoken($request)->type != $appSuperAdminUser) {

            $msg = "you don't have permission to perform this action";
    
            return $this->generalResponse(false,401,$msg, null,null);

        }

        return $next($request);
    }
}
