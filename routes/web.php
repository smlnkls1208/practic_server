<?php

use Src\Route;

Route::add('GET', '/', [Controller\Site::class, 'home'])->middleware('auth');
Route::add('GET', '/dashboard', [Controller\Site::class, 'home'])->middleware('auth');

Route::add(['GET', 'POST'], '/login', [Controller\Site::class, 'login']);
Route::add('GET', '/logout', [Controller\Site::class, 'logout'])->middleware('auth');

Route::add(['GET', 'POST'], '/employees/create', [Controller\EmployeeController::class, 'create'])
    ->middleware('auth', 'role:admin');

Route::add(['GET', 'POST'], '/patients', [Controller\PatientController::class, 'index'])
    ->middleware('auth', 'role:admin,employee');
Route::add(['GET', 'POST'], '/doctors', [Controller\DoctorController::class, 'index'])
    ->middleware('auth', 'role:admin,employee');
Route::add(['GET', 'POST'], '/appointments', [Controller\AppointmentController::class, 'index'])
    ->middleware('auth', 'role:admin,employee');
Route::add('POST', '/appointments/cancel', [Controller\AppointmentController::class, 'cancel'])
    ->middleware('auth', 'role:admin,employee');
