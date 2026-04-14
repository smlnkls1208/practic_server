<?php

return [
    'auth' => \Src\Auth\Auth::class,
    'identity' => \Model\User::class,
    'providers' => [
        'kernel' => \Providers\KernelProvider::class,
        'route' => \Providers\RouteProvider::class,
        'db' => \Providers\DBProvider::class,
        'auth' => \Providers\AuthProvider::class,
    ],
    'routeMiddleware' => [
        'auth' => \Middlewares\AuthMiddleware::class,
        'role' => \Middlewares\RoleMiddleware::class,
        'apiAuth' => \Middlewares\ApiAuthMiddleware::class,
    ],
    'routeAppMiddleware' => [
        'csrf' => \Middlewares\CSRFMiddleware::class,
        'trim' => \Middlewares\TrimMiddleware::class,
        'json' => \Middlewares\JSONMiddleware::class,
        'specialChars' => \Middlewares\SpecialCharsMiddleware::class,
    ],
    'validators' => [
        'required' => \Validators\RequireValidator::class,
        'unique' => \Validators\UniqueValidator::class,
        'min' => \Validators\MinValidator::class,
        'max' => \Validators\MaxValidator::class,
    ],
];
