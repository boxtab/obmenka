<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @param $listRole
     * @return \Illuminate\Http\RedirectResponse|mixed
     */
    public function handle(Request $request, Closure $next, $listRole)
    {
        if ( ! userOwnRole($listRole, Auth::user()->role_id) ) {
            return redirect()->route('access-denied');
        } else {
            return $next($request);
        }
        /*
        $authRoleId = Auth::user()->role_id;
        $authRoleSlug = array_search( $authRoleId, Config('constants.role') );
        $transferArrayRole = explode('/', $listRole);
        $allowCurrentUser = in_array( $authRoleSlug, $transferArrayRole );

        if ( ! $allowCurrentUser ) {
            return redirect()->route('access-denied');
        } else {
            return $next($request);
        }
        */

//        return response(view('access-denied'),403);
//        return route('access-denied');
//        return $next($request);
    }
}
