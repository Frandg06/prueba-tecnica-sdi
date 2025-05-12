<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class i18nMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if ($request->has('lang')) {

            $lang = match ($request->input('lang')) {
                'es', 'es_ES' => 'es',
                'en', 'en_US', 'en_GB', 'en_EN' => 'en',
                default => 'es',
            };

            App::setLocale($lang);
        }

        return $next($request);
    }
}
