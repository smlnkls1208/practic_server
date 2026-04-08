<?php

namespace Src\Auth;

use Src\Session;
use Throwable;

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
        try {
            if ($user = self::$user->attemptIdentity($credentials)) {
                self::login($user);
                return true;
            }
        } catch (Throwable $exception) {
            return false;
        }

        return false;
    }

    public static function user()
    {
        $id = Session::get('id') ?? 0;
        try {
            return self::$user->findIdentity((int)$id);
        } catch (Throwable $exception) {
            return null;
        }
    }

    public static function check(): bool
    {
        return (bool)self::user();
    }

    public static function logout(): bool
    {
        Session::clear('id');
        return true;
    }
}
