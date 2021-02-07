<?php

namespace App\Http\Middleware;
use App\Traits\Genralfunction;
use Closure;

class HaveResetToken
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
        $HaveResetToken = $this->checkResetToken($request);

        
        if (!$HaveResetToken) {

            $msg = 'invalid token';
            return $this->generalResponse(false,401,$msg, null,null);
        }elseif($HaveResetToken->IsActive != 1) {
            $msg = 'user not activated';
            return $this->generalResponse(false,401,$msg, null,null); 
        } else {
            return $next($request);
        }
        
    }
}
