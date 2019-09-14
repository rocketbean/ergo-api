<?php

namespace App\Http\Middleware\Supplier\User;

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
        if ($request->route('supplier')->authorized('invite_user'))
            return $next($request);
        else
            return response()->json('you do not have the permission invite a user', 401);
    }
}
