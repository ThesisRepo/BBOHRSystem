<?php

namespace App\Http\Middleware\VerifyUserType;

use Closure;

class VerifyIfGenManager
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
        if(!in_array('general mngr', $request->user()->roles->pluck('role_name')->toArray())) {
            if($request->wantsJSON()) {
                return response()->json(['Message', 'opps! your not authorized'], 403);
            }
            abort(403, 'opps! your not authorized');
        }
        return $next($request);
    }
}
