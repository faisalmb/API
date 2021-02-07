<?php

namespace App\Http\Middleware;
use App\Traits\Genralfunction;
use Closure;
use App\Model\companyUser;

class CheckCompanyId
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
                
        if ($this->checkHeadersCompanyId($request)->status != 200) {

            return $this->generalResponse(false,401,$this->checkHeadersCompanyId($request)->content, null,null);
        }

       return $next($request);
    }
}
