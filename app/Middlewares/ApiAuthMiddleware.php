<?php

namespace Middlewares;

use Src\Auth\Auth;
use Src\Request;
use Src\View;

class ApiAuthMiddleware
{
    public function handle(Request $request): void
    {
        if ($request->bearerToken() && Auth::check($request)) {
            return;
        }

        (new View())->toJSON([
            'message' => 'Требуется Bearer token',
        ], 401);
    }
}
