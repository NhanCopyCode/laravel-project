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
        $userRole = strtolower($this->getUserType(Auth::user()->role_id));
        if(in_array($userRole, $allowRoles)) {

            return $next($request);

        }
        return redirect()->route('403');
    }

    public function getUserType($role_id)
    {
        // dd(config('permission'));
        $permission_mapping =  array_flip(config('permission'));

        return $permission_mapping[$role_id];
    }
}
