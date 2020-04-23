<?php

namespace App\Http\Middleware;

use Closure;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ClearanceMiddleware {
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {      
          
        if (Auth::user()->can('Administer-roles-permissions')) //If user has this //permission
        {
            return $next($request);
        }
        // if (Auth::user()->can('Admin-Editor')) //If user has this //permission
        // {
        //     return $next($request);
        // }

        // if ($request->is('/hotel-agent-register-get'))//If user is creating a post
        //  {
        //     if (!Auth::user()->hasPermissionTo('Admin-Editor'))
        //     {
        //         abort('401');
              
        //     } 
        //  else {
        //     return $next($request);
        //     }
        // }
       
       

        // if ($request->is('/vehicle-agent-register-get')) //If user is editing a post
        //  {
        //     if (!Auth::user()->hasPermissionTo('Editor-Vehicle')) {
        //         abort('401');
        //     } else {
        //         return $next($request);
        //     }
        // }

        // if ($request->isMethod('Delete')) //If user is deleting a post
        //  {
        //     if (!Auth::user()->hasPermissionTo('Delete Post')) {
        //         abort('401');
        //  } 
        //  else 
        //  {
        //         return $next($request);
        //     }
        // }

        return $next($request);
    }
}
