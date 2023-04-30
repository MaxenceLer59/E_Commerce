<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     * return a status code 401
     */
    protected function redirectTo(Request $request): ?string
    {
        return $request->expectsJson() ? null : route('failAuthMiddleware');
    }
}
