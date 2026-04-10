<?php

namespace Src;

use FastRoute\DataGenerator\MarkBased;
use FastRoute\Dispatcher\MarkBased as Dispatcher;
use FastRoute\RouteCollector;
use FastRoute\RouteParser\Std;
use Src\Traits\SingletonTrait;

class Middleware
{
    use SingletonTrait;

    private RouteCollector $middlewareCollector;

    public function add($httpMethod, string $route, array $action): void
    {
        $this->middlewareCollector->addRoute($httpMethod, $route, $action);
    }

    public function group(string $prefix, callable $callback): void
    {
        $this->middlewareCollector->addGroup($prefix, $callback);
    }

    private function __construct()
    {
        $this->middlewareCollector = new RouteCollector(new Std(), new MarkBased());
    }

    public function go(string $httpMethod, string $uri, Request $request): Request
    {
        return $this->runMiddlewares($httpMethod, $uri, $this->runAppMiddlewares($request));
    }

    private function runMiddlewares(string $httpMethod, string $uri, Request $request): Request
    {
        $routeMiddleware = app()->settings->app['routeMiddleware'] ?? [];

        foreach ($this->getMiddlewaresForRoute($httpMethod, $uri) as $middleware) {
            $args = explode(':', $middleware, 2);
            $name = $args[0] ?? '';
            $argument = $args[1] ?? null;

            if (!isset($routeMiddleware[$name])) {
                continue;
            }

            if ($argument === null) {
                $request = (new $routeMiddleware[$name])->handle($request) ?? $request;
                continue;
            }

            $request = (new $routeMiddleware[$name])->handle($request, $argument) ?? $request;
        }

        return $request;
    }

    private function runAppMiddlewares(Request $request): Request
    {
        $routeMiddleware = app()->settings->app['routeAppMiddleware'] ?? [];

        foreach ($routeMiddleware as $name => $class) {
            $args = explode(':', $name, 2);
            if (!isset($args[1])) {
                $request = (new $class)->handle($request) ?? $request;
                continue;
            }

            $request = (new $class)->handle($request, $args[1]) ?? $request;
        }

        return $request;
    }

    private function getMiddlewaresForRoute(string $httpMethod, string $uri): array
    {
        $dispatcherMiddleware = new Dispatcher($this->middlewareCollector->getData());
        return $dispatcherMiddleware->dispatch($httpMethod, $uri)[1] ?? [];
    }
}
