<?php

namespace Controller;

use Src\Auth\Auth;
use Src\Request;
use Src\View;

class Site
{
    public function home(Request $request): string
    {
        return new View('site.dashboard', [
            'user' => app()->auth::user(),
        ]);
    }

    public function login(Request $request): string
    {
        if ($request->method === 'GET') {
            return new View('site.login');
        }

        if (Auth::attempt($request->all())) {
            app()->route->redirect('/dashboard');
            return '';
        }

        return new View('site.login', [
            'message' => 'Неправильные логин или пароль',
            'old' => $request->all(),
        ]);
    }

    public function logout(Request $request): void
    {
        Auth::logout();
        app()->route->redirect('/login');
    }
}
