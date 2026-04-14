<?php

namespace Src;

use Error;

class Settings
{
    private array $settings;

    public function __construct(array $settings = [])
    {
        $this->settings = $settings;
    }

    public function __get($key)
    {
        if (array_key_exists($key, $this->settings)) {
            return $this->settings[$key];
        }

        throw new Error('Accessing a non-existent property');
    }

    public function getRootPath(): string
    {
        return !empty($this->path['root']) ? '/' . $this->path['root'] : '';
    }

    public function getViewsPath(): string
    {
        return '/' . ($this->path['views'] ?? 'views');
    }

    public function getRoutePath(): string
    {
        return '/' . ($this->path['routes'] ?? 'routes');
    }

    public function getDbSetting(): array
    {
        return $this->db ?? [];
    }

    public function getAuthClassName(): string
    {
        return $this->app['auth'] ?? '';
    }

    public function getIdentityClassName(): string
    {
        return $this->app['identity'] ?? '';
    }

    public function removeAppMiddleware(string $key): void
    {
        unset($this->settings['app']['routeAppMiddleware'][$key]);
    }
}
