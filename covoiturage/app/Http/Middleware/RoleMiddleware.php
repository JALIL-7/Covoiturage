<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!auth()->guard()->check()) {
            return redirect()->route('login');
        }

        $userRole = auth()->guard()->user()->role;

        if ($userRole === 'admin') {
            return $next($request);
        }

        $allowed = empty($roles) ? false : in_array($userRole, $roles, true);

        if (! $allowed) {
            return redirect()->route('dashboard')->with('error', 'Accès non autorisé');
        }

        return $next($request);
    }
}
