<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckPermissionAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        $allowRoles = array_map('strtolower', explode('|', $role)); 
        $adminRole = null;
        if(Auth::guard('admin')->check()) {
            $adminRole = strtolower($this->getUserType(Auth::guard('admin')->user()->role_id));
        }

        if( in_array($adminRole, $allowRoles)) {
            return $next($request);
        }

        return redirect()->route('auth.login_admin');
    }
    public function getUserType($role_id)
    {
        // dd(config('permission'));
        $permission_mapping =  array_flip(config('permission'));

        return $permission_mapping[$role_id];
    }
}
