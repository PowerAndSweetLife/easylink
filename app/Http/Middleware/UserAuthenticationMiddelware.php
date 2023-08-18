<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class UserAuthenticationMiddelware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $routeName = $request->route()->getName();
        $parts = explode(".", $routeName);
        $user = $parts[0];

        if(!$request->session()->has($user))
        {
            return redirect(route("$user.login"));
        }

        if($user === 'client')
        {
            if($request->session()->get($user)['confirmed'] === false)
            {
                return redirect(route('client.confirm-email'));
            }
        }
        App::setLocale($request->session()->get($user)['lang']);
        return $next($request);
    }
}
