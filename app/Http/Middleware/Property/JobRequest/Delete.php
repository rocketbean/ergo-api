<?php

namespace App\Http\Middleware\Property\JobRequest;

use Closure;

class Delete
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
        if ($request->route('property')->authorized('delete_jobrequest'))
            return $next($request);
        else
            return response()->json('unauthorized access', 401);
    }
}
