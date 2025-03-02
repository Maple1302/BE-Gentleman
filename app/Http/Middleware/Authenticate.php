<?php

namespace App\Http\Middleware;

use App\Traits\APIResponse;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    use APIResponse;
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
   // protected function redirectTo(Request $request): ?string
   // {
    //    return $request->expectsJson() ? null : route('login');
   // }

    public function handle($request, $next, ...$guards)
    {
        if ($this->auth->guard('sanctum')->check()) {
            $this->auth->shouldUse('api');
        }else
        {
            return $this->responseUnAuthenticated();
        }
        return $next($request);
    }
}
