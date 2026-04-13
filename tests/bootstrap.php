<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/ControllerTestCase.php';

if (!function_exists('app')) {
    function app()
    {
        return $GLOBALS['app'];
    }
}

class TestRoute
{
    public ?string $redirectUrl = null;

    public function redirect(string $url): void
    {
        $this->redirectUrl = $this->getUrl($url);
    }

    public function getUrl(string $url): string
    {
        return $url;
    }
}

class TestApp
{
    public \Src\Settings $settings;
    public TestRoute $route;
    public \Src\Auth\Auth $auth;

    public function __construct(\Src\Settings $settings, TestRoute $route)
    {
        $this->settings = $settings;
        $this->route = $route;
        $this->auth = new \Src\Auth\Auth();
    }
}
