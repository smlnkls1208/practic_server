<?php

namespace Src;

use Error;

class Request
{
    protected array $body;
    public string $method;
    public array $headers;

    public function __construct()
    {
        $this->body = $_REQUEST;
        $this->method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        $this->headers = $this->resolveHeaders();
    }

    public function all(): array
    {
        return $this->body + $this->files();
    }

    public function set($field, $value): void
    {
        $this->body[$field] = $value;
    }

    public function get($field, $default = null)
    {
        return $this->body[$field] ?? $default;
    }

    public function files(): array
    {
        return $_FILES;
    }

    public function bearerToken(): ?string
    {
        $header = $this->header('Authorization');

        if (!$header || stripos($header, 'Bearer ') !== 0) {
            return null;
        }

        $token = trim(substr($header, 7));

        return $token !== '' ? $token : null;
    }

    public function header(string $name, $default = null)
    {
        foreach ($this->headers as $header => $value) {
            if (strcasecmp($header, $name) === 0) {
                return $value;
            }
        }

        return $default;
    }

    public function __get($key)
    {
        if (array_key_exists($key, $this->body)) {
            return $this->body[$key];
        }

        throw new Error('Accessing a non-existent property');
    }

    private function resolveHeaders(): array
    {
        if (function_exists('getallheaders')) {
            $headers = getallheaders();
            if (!empty($headers)) {
                return $headers;
            }
        }

        $headers = [];

        foreach ($_SERVER as $key => $value) {
            if (strpos($key, 'HTTP_') !== 0) {
                continue;
            }

            $name = str_replace('_', '-', strtolower(substr($key, 5)));
            $headers[ucwords($name, '-')] = $value;
        }

        if (isset($_SERVER['CONTENT_TYPE'])) {
            $headers['Content-Type'] = $_SERVER['CONTENT_TYPE'];
        }

        return $headers;
    }
}
