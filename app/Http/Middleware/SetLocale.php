<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        $locale = session('locale', 'en');
        if (array_key_exists($locale, config('arusuvai.languages'))) {
            app()->setLocale($locale);
        }

        return $next($request);
    }
}
