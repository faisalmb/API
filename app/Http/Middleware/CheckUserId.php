<?php

namespace App\Http\Middleware;
use App\Traits\Genralfunction;
use Closure;
// use App\companyUser;

class CheckUserId
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

       
        // $id = $this->checktoken($request)->id;
                
        if ($this->checkHeadersUserId($request)->status != 200) {

            return $this->generalResponse(false,401,$this->checkHeadersUserId($request)->content, null,null);
        }

       return $next($request);
    }
}
