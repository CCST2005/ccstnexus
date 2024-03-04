<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRequestMethod
{
    public function handle($request, Closure $next)
    {
        if ($request->isMethod('post') && $request->method() === 'GET') {
            return redirect()->route('admin.index');
        }

        return $next($request);
    }
}
