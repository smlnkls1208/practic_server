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

    public function runMiddlewares(string $httpMethod, string $uri): Request
    {
        $request = new Request();
        $routeMiddleware = app()->settings->app['routeMiddleware'] ?? [];

        foreach ($this->getMiddlewaresForRoute($httpMethod, $uri) as $middleware) {
            $args = explode(':', $middleware, 2);
            $name = $args[0] ?? '';
            $argument = $args[1] ?? null;

            if (!isset($routeMiddleware[$name])) {
                continue;
            }

            $middlewareObject = new $routeMiddleware[$name];

            if ($argument === null) {
                $middlewareObject->handle($request);
                continue;
            }

            $middlewareObject->handle($request, $argument);
        }

        return $request;
    }

    private function getMiddlewaresForRoute(string $httpMethod, string $uri): array
    {
        $dispatcherMiddleware = new Dispatcher($this->middlewareCollector->getData());
        return $dispatcherMiddleware->dispatch($httpMethod, $uri)[1] ?? [];
    }
}
