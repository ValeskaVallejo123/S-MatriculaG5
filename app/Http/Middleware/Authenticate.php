<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Authenticate
{
    public function handle(Request $request, Closure $next, $guard = null)
    {
        if (!Auth::check()) {
            return redirect()->route('login.show')->with('error', 'Debes iniciar sesión.');
        }
        return $next($request);
    }
}
