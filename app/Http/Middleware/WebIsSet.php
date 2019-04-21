<?php

namespace App\Http\Middleware;

use Closure;

class WebIsSet
{
    public function handle($request, Closure $next)
    {
        if (!\App\SiteSetting::count()) {
            return redirect('wizard');
        }

        return $next($request);
    }
}
