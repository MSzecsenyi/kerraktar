<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsPasswordSetMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && auth()->user()->password == 'not_created' && !$request->password && !$request->is('setpassword')) {
            return redirect()->route('setpassword');
        }
        return $next($request);
    }
}
