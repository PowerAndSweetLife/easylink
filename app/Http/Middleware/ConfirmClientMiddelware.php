<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ConfirmClientMiddelware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(!$request->session()->has('client'))
        {
            return redirect(route("client.login"));
        }

        if($request->session()->get('client')['confirmed'] === true)
        {
            return redirect(route('client.index'));
        }

        return $next($request);
    }
}
