<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class PermissionChecker
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {

        // dd();
        $allowRoles = array_map('strtolower', explode('|', $role)); 
        $userRole = null;
        $adminRole = null;
        // if(Auth::guard('admin')->check()) {
        //     $adminRole = strtolower($this->getUserType(Auth::guard('admin')->user()->role_id));
        // }

        if(Auth::guard('web')->check() && Auth::guard('web')->user()->user_status_id === 1) {

            $userRole = strtolower($this->getUserType(Auth::guard('web')->user()->role_id));
        }else {
            Auth::guard('web')->logout();
            return redirect()->route('403');

        }
        if(in_array($userRole, $allowRoles) || in_array($adminRole, $allowRoles)) {
            
            return $next($request);

        }
        // Auth::guard('web')->logout();
        return redirect()->route('403');
    }

    public function getUserType($role_id)
    {
        // dd(config('permission'));
        $permission_mapping =  array_flip(config('permission'));

        return $permission_mapping[$role_id];
    }
}
