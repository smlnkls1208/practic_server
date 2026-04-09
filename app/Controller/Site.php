<?php

namespace Controller;

use Model\Role;
use Model\User;
use Src\Auth\Auth;
use Src\Request;
use Src\View;

class Site
{
    public function home(Request $request): string
    {
        $user = app()->auth::user();

        return new View('site.dashboard', [
            'user' => $user,
        ]);
    }

    public function login(Request $request): string
    {
        if ($request->method === 'GET') {
            return new View('site.login');
        }

        $login = trim((string)$request->get('login', ''));
        $password = trim((string)$request->get('password', ''));

        if ($login === '' || $password === '') {
            return new View('site.login', ['message' => 'Логин и пароль обязательны']);
        }

        if (Auth::attempt(['login' => $login, 'password' => $password])) {
            app()->route->redirect('/dashboard');
        }

        return new View('site.login', ['message' => 'Неправильные логин или пароль']);
    }

    public function logout(Request $request): void
    {
        Auth::logout();
        app()->route->redirect('/login');
    }

    public function createEmployee(Request $request): string
    {
        $roles = Role::orderBy('id')->get();

        if ($request->method === 'POST') {
            $login = trim((string)$request->get('login', ''));
            $password = trim((string)$request->get('password', ''));
            $roleId = (int)$request->get('role_id', 0);

            if ($login === '' || $password === '' || $roleId <= 0) {
                return new View('site.employee-create', [
                    'roles' => $roles,
                    'employees' => User::with('role')->orderBy('id', 'desc')->get(),
                    'message' => 'Заполните все поля',
                ]);
            }

            if (User::where('login', $login)->exists()) {
                return new View('site.employee-create', [
                    'roles' => $roles,
                    'employees' => User::with('role')->orderBy('id', 'desc')->get(),
                    'message' => 'Логин уже занят',
                ]);
            }

            User::create([
                'login' => $login,
                'password' => $password,
                'role_id' => $roleId,
            ]);
        }

        return new View('site.employee-create', [
            'roles' => $roles,
            'employees' => User::with('role')->orderBy('id', 'desc')->get(),
            'message' => $request->method === 'POST' ? 'Сотрудник успешно добавлен' : null,
        ]);
    }

    public function patientsPage(Request $request): string
    {
        return new View('site.patients');
    }

    public function doctorsPage(Request $request): string
    {
        return new View('site.doctors');
    }

    public function appointmentsPage(Request $request): string
    {
        return new View('site.appointments');
    }
}
