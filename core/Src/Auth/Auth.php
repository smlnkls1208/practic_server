<?php

namespace Src\Auth;

use Src\Request;
use Src\Session;

class Auth
{
    private static IdentityInterface $user;

    public static function init(IdentityInterface $user): void
    {
        self::$user = $user;

        if (self::user()) {
            self::login(self::user());
        }
    }

    public static function login(IdentityInterface $user): void
    {
        self::$user = $user;
        Session::set('id', self::$user->getId());
    }

    public static function attempt(array $credentials): bool
    {
        if ($user = self::$user->attemptIdentity($credentials)) {
            self::login($user);
            return true;
        }

        return false;
    }

    public static function attemptToken(array $credentials): ?string
    {
        $user = self::$user->attemptIdentity($credentials);

        if (!$user || !method_exists($user, 'issueApiToken')) {
            return null;
        }

        return $user->issueApiToken();
    }

    public static function user(?Request $request = null)
    {
        $token = $request?->bearerToken();

        if ($token && method_exists(self::$user, 'findIdentityByToken')) {
            return self::$user->findIdentityByToken($token);
        }

        $id = Session::get('id') ?? 0;
        return self::$user->findIdentity((int)$id);
    }

    public static function check(?Request $request = null): bool
    {
        return (bool)self::user($request);
    }

    public static function logout(): bool
    {
        Session::clear('id');
        Session::clear('csrf_token');
        return true;
    }

    public static function generateCSRF(): string
    {
        $token = md5((string)time());
        Session::set('csrf_token', $token);
        return $token;
    }
}
