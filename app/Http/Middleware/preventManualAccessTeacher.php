<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class preventManualAccessTeacher
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        // Check if the session variable exists
        if (!session()->has('user_logged_teacher')) {
            // Redirect to the login page
            return redirect('/teacher');
        }

        return $next($request);
    }
}
