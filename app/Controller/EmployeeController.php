<?php

namespace Controller;

use Model\Role;
use Model\User;
use PhpValidator\Validator;
use Src\Request;
use Src\View;

class EmployeeController
{
    public function create(Request $request): string
    {
        if ($request->method === 'POST') {
            $validator = new Validator($request->all(), [
                'login' => ['required', 'min:4', 'max:30', 'unique:users,login'],
                'password' => ['required', 'min:4', 'max:50'],
            ]);

            $errors = [];
            $employeeRole = Role::query()->where('name', 'employee')->first();

            if ($validator->fails()) {
                $validatorErrors = $validator->errors();
                $errors['login'] = $this->localizeError($validatorErrors['login'][0] ?? null);
                $errors['password'] = $this->localizeError($validatorErrors['password'][0] ?? null);
                $errors = array_filter($errors);
            }

            if (!$employeeRole) {
                $errors['form'] = 'Роль employee не найдена';
            }

            if (!empty($errors)) {
                return new View('site.employee-create', [
                    'employees' => User::with('role')->orderBy('id', 'desc')->get(),
                    'errors' => $errors,
                    'old' => $request->all(),
                ]);
            }

            User::create([
                'login' => (string)$request->get('login', ''),
                'password' => (string)$request->get('password', ''),
                'role_id' => $employeeRole->id,
            ]);

            app()->route->redirect('/employees/create');
            return '';
        }

        return new View('site.employee-create', [
            'employees' => User::with('role')->orderBy('id', 'desc')->get(),
        ]);
    }

    private function localizeError(?string $message): ?string
    {
        if ($message === null) {
            return null;
        }

        return str_replace(
            ['login', 'password'],
            ['логин', 'пароль'],
            $message
        );
    }
}
