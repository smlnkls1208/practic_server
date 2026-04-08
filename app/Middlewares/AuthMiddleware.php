<?php

namespace Middlewares;

use Src\Auth\Auth;
use Src\Request;

class AuthMiddleware
{
    public function handle(Request $request, ?string $argument = null): void
    {
        if (!Auth::check()) {
            app()->route->redirect('/login');
        }
    }
}