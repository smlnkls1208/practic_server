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
        return new View('site.dashboard');
    }

    public function forbidden(Request $request): string
    {
        return new View('site.forbidden');
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

        if ($request->method === 'GET') {
            return new View('site.employee-create', ['roles' => $roles]);
        }

        $login = trim((string)$request->get('login', ''));
        $password = trim((string)$request->get('password', ''));
        $roleId = (int)$request->get('role_id', 0);

        if ($login === '' || $password === '' || $roleId <= 0) {
            return new View('site.employee-create', [
                'roles' => $roles,
                'message' => 'Заполните все поля',
            ]);
        }

        if (User::where('login', $login)->exists()) {
            return new View('site.employee-create', [
                'roles' => $roles,
                'message' => 'Логин уже занят',
            ]);
        }

        User::create([
            'login' => $login,
            'password' => $password,
            'role_id' => $roleId,
        ]);

        return new View('site.employee-create', [
            'roles' => $roles,
            'message' => 'Сотрудник успешно добавлен',
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

    public function reportsPage(Request $request): string
    {
        return new View('site.reports');
    }
}