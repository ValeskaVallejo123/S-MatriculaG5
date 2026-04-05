<?php

namespace App\Helpers;

class NavHistory
{
    public static function previous(string $fallback = '/'): string
    {
        $history = session('nav_history', []);
        $current = request()->fullUrl();

        $index = array_search($current, $history);

        if ($index !== false && $index > 0) {
            return $history[$index - 1];
        }

        if (count($history) >= 2) {
            return $history[count($history) - 2];
        }

        return $fallback;
    }
}
