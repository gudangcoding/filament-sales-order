<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class TenantMiddleware
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
        // Default value for tenantMenu
        $tenantMenu = false;

        // Check if the user is authenticated
        if ($user = Auth::user()) {
            // Check the user's role
            $roleName = auth()->user()->roles->first()->name;
            if ($roleName == "super_admin" || $roleName == "admin") {
                $tenantMenu = true;
            }
        }

        // Share tenantMenu value with the request
        $request->attributes->set('tenantMenu', $tenantMenu);

        return $next($request);
    }
}
