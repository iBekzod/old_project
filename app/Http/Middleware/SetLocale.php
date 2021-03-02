<?php

namespace App\Http\Middleware;

use Closure;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($locale = $this->parseLocale($request)) {
            app()->setLocale($locale);
        }

        return $next($request);
    }

    /**
     * @param  \Illuminate\Http\Request $request
     * @return string|null
     */
    protected function parseLocale($request)
    {
        $locales = \App\Models\Language::all()->pluck('code');

        $locale = $request->header('accept-language');
        $locale = substr($locale, 0, strpos($locale, ',') ?: strlen($locale));

        if (in_array($locale, $locales->toArray())) {
            return $locale;
        }

        $locale = substr($locale, 0, 2);
        if (in_array($locale, $locales->toArray())) {
            return $locale;
        }
    }
}
