<?php

namespace App\Http\Middleware;
use App\Traits\Genralfunction;
use Closure;

class HaveToken
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
        $haveToken = $this->checktoken($request);

        
        if (!$haveToken) {
            $msg = 'invalid token';
            return $this->generalResponse(false,401,$msg, null,null);
        }elseif($haveToken->IsActive != 1) {
            $msg = 'user not activated';
            return $this->generalResponse(false,401,$msg, null,null);
        }elseif($haveToken->IsConfirmedPhone != 1) {
            $msg = 'user phone not Confirmed';
            return $this->generalResponse(false,401,$msg, null,null);
        }else {
            return $next($request);
        }
        
    }
}
