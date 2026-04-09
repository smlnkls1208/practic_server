<?php

use Src\Route;

Route::add('GET', '/', [Controller\Site::class, 'home'])->middleware('auth');
Route::add('GET', '/dashboard', [Controller\Site::class, 'home'])->middleware('auth');

Route::add(['GET', 'POST'], '/login', [Controller\Site::class, 'login']);
Route::add('GET', '/logout', [Controller\Site::class, 'logout'])->middleware('auth');

Route::add(['GET', 'POST'], '/employees/create', [Controller\Site::class, 'createEmployee'])
    ->middleware('auth', 'role:admin');

Route::add('GET', '/patients', [Controller\Site::class, 'patientsPage'])
    ->middleware('auth', 'role:admin,employee');
Route::add('GET', '/doctors', [Controller\Site::class, 'doctorsPage'])
    ->middleware('auth', 'role:admin,employee');
Route::add('GET', '/appointments', [Controller\Site::class, 'appointmentsPage'])
    ->middleware('auth', 'role:admin,employee');
