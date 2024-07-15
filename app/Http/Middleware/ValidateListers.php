<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ValidateListers
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!
            (auth()->user()->role->title == 'Lister')
            ) {
                $response = [
                    'error' => 'Request denied',
                ];
                return response($response, 403);
            }
        return $next($request);
    }
}
