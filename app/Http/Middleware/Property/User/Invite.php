<?php

namespace App\Http\Middleware\Property\User;

use Closure;

class Invite
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
        if ($request->route('property')->authorized('invite_user'))
            return $next($request);
        else
            return response()->json('you do not have the permission to publish a jobrequest', 401);
    }
}
