<?php

namespace App\Http\Middleware;
use App\Traits\Genralfunction;

use Closure;

class CheckHeaders
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
        $header = $this->checkheaders($request);

        if ($header != 200) {


            return $this->checkError($header);
        }

        return $next($request);
    }
}
