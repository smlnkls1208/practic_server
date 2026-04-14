<?php

namespace Middlewares;

use Src\Auth\Auth;
use Src\Request;

class RoleMiddleware
{
    public function handle(Request $request, ?string $rolesRaw = null): void
    {
        if (!Auth::check($request)) {
            app()->route->redirect('/login');
        }

        if ($rolesRaw === null) {
            return;
        }

        $allowedRoles = array_map('trim', explode(',', $rolesRaw));
        $currentRole = Auth::user($request)?->role?->name;

        if (!$currentRole || !in_array($currentRole, $allowedRoles, true)) {
            app()->route->redirect('/login');
        }
    }
}
