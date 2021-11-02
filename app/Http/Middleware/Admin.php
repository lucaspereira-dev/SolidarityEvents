<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class Admin
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

        $token = JWTAuth::getToken();
        $user = JWTAuth::toUser($token);

        if ($user && $user->adm > 0)
        {
            return $next($request);
        }

        return response()->json([
            'error' => 'Unauthorized'
        ], 401);
    }
}
