<?php
namespace App\Http\Middleware;

use Closure;
use Spatie\Csp\Csp;

class ContentSecurityPolicy
{
    public function handle($request, Closure $next)
    {
        Csp::addDirective('default-src', ['self'])
            ->addDirective('script-src', ['self', 'https://cdn.jsdelivr.net'])
            ->addDirective('style-src', ['self', 'https://cdn.jsdelivr.net']);

        return $next($request);
    }
}