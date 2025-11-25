<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, $guard = null)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $redirectTo = $user->rol === 'admin' ? route('admins.index') : route('matriculas.index');
            return redirect($redirectTo);
        }

        return $next($request);
    }
}
