<?php

namespace Controller;

use Model\Role;
use Model\User;
use Src\Request;
use Src\Validator\Validator;
use Src\View;

class EmployeeController
{
    use ControllerHelper;

    public function create(Request $request): string
    {
        if ($request->method === 'POST') {
            $validator = new Validator($request->all(), [
                'login' => ['required', 'min:4', 'max:30', 'unique:users,login'],
                'password' => ['required', 'min:4', 'max:50'],
            ]);

            $errors = $this->formatErrors($validator);
            $employeeRole = Role::query()->where('name', 'employee')->first();

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
}
