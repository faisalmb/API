<?php

namespace App\Http\Middleware;
use App\Traits\Genralfunction;

use Closure;

class HaveBrach
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
        if ($this->haveBrach($request)->status != 200) {

            return $this->generalResponse(false,401,$this->haveBrach($request)->content, null,null);
      
        }

       return $next($request);
    }
}
