<?php

namespace Modules\Core\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class SetLocale {
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next) {
        if (Auth::check() && Auth::user()->locale) {
            app()->setLocale(Auth::user()->locale);
        }
        $direction = in_array(
            app()->getLocale(),
            config('core.locales.rtl', [])
        ) ? 'rtl' : 'ltr';
        View::share('textDirection', $direction);
        return $next($request);
    }
}
