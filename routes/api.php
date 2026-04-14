<?php

use Src\Route;

Route::add('GET', '/', [Controller\Api::class, 'index']);
Route::add('POST', '/login', [Controller\Api::class, 'login']);
Route::add('GET', '/appointments', [Controller\Api::class, 'appointments'])->middleware('apiAuth');
Route::add('POST', '/echo', [Controller\Api::class, 'echo']);
