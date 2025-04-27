<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FilamentAuthenticate
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! auth()->check()) {
            abort(403);
        }

        return $next($request);
    }
}