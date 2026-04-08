<?php

namespace Src;

class Session
{
    public static function set($name, $value): void
    {
        $_SESSION[$name] = $value;
    }

    public static function get($name)
    {
        return $_SESSION[$name] ?? null;
    }

    public static function clear($name): void
    {
        unset($_SESSION[$name]);
    }

    public static function flash(string $name, ?string $value = null)
    {
        if ($value !== null) {
            self::set('__flash_' . $name, $value);
            return null;
        }

        $key = '__flash_' . $name;
        $result = self::get($key);
        self::clear($key);

        return $result;
    }
}