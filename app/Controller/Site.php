<?php

namespace Controller;

use Illuminate\Database\Capsule\Manager as DB;
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
        return new View('site.patients', [
            'patients' => DB::table('patients')->orderBy('id', 'desc')->get(),
        ]);
    }

    public function doctorsPage(Request $request): string
    {
        return new View('site.doctors', [
            'doctors' => DB::table('doctors')
                ->leftJoin('positions', 'positions.id', '=', 'doctors.position_id')
                ->leftJoin('specializations', 'specializations.id', '=', 'doctors.specialization_id')
                ->select(
                    'doctors.id',
                    'doctors.name',
                    'doctors.surname',
                    'doctors.patronym',
                    'doctors.birth_date',
                    'positions.name as position_name',
                    'specializations.name as specialization_name'
                )
                ->orderBy('doctors.id', 'desc')
                ->get(),
            'positions' => DB::table('positions')->orderBy('name')->get(),
            'specializations' => DB::table('specializations')->orderBy('name')->get(),
        ]);
    }

    public function appointmentsPage(Request $request): string
    {
        return new View('site.appointments', [
            'appointments' => DB::table('appointments')
                ->leftJoin('patients', 'patients.id', '=', 'appointments.patient_id')
                ->leftJoin('doctors', 'doctors.id', '=', 'appointments.doctor_id')
                ->select(
                    'appointments.id',
                    'appointments.appointment_at',
                    'patients.surname as patient_surname',
                    'patients.name as patient_name',
                    'patients.patronym as patient_patronym',
                    'doctors.surname as doctor_surname',
                    'doctors.name as doctor_name',
                    'doctors.patronym as doctor_patronym'
                )
                ->orderBy('appointments.appointment_at', 'desc')
                ->get(),
            'patients' => DB::table('patients')->orderBy('surname')->orderBy('name')->get(),
            'doctors' => DB::table('doctors')->orderBy('surname')->orderBy('name')->get(),
        ]);
    }
}
