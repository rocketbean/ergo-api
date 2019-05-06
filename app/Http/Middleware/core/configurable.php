<?php

namespace App\Http\Middleware\core;
use App\Services\ErgoService;
use Closure;

class configurable
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if( ErgoService::GetConfig('status') !== 'configurable' ){
            return response()->json('the system is not on cofiguration mode!', 405);
        }
        return $next($request);
    }
}
