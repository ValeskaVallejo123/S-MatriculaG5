<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class TrackNavigationHistory
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->isMethod('GET') && !$request->ajax()) {
            $current = $request->fullUrl();
            $history = session('nav_history', []);
            $last = end($history);

            if ($last !== $current) {
                $index = array_search($current, $history);
                if ($index !== false) {
                    $history = array_slice($history, 0, $index + 1);
                } else {
                    $history[] = $current;
                }
                if (count($history) > 15) {
                    $history = array_slice($history, -15);
                }
                session(['nav_history' => $history]);
            }
        }
        return $next($request);
    }
}
