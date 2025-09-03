<?php

namespace Core\Server;

class Request{

    private array $params = [];
    private string $method;
    private string $router;

    public function __construct(string $router, string $method, array $params = []){
        $this->router = $router;
        $this->method = strtoupper($method);
        $this->params = $params;
    }

    public static function getRouterRequested(): string{
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '/';
        return rtrim($path, '/') ?: '/';
    }

    public static function getMethodHttpRequested(): string{
        return $_SERVER['REQUEST_METHOD'] ?? 'GET';
    }

    public static function fromGlobals(): self{
        $method = self::getMethodHttpRequested();
        $router = self::getRouterRequested();
        $params = [];

        switch ($method) {
            case 'GET':
                $params = $_GET;
                break;
            case 'POST':
            case 'PUT':
            case 'PATCH':
            case 'DELETE':
                $input = file_get_contents('php://input');
                $data = json_decode($input, true);
                $params = $data ?? $_POST;
                break;
        }

        return new self($router, $method, $params);
    }

    public function getParams(): array{
        return $this->params;
    }

    public function getParam(string $key, mixed $default = null): mixed{
        return $this->params[$key] ?? $default;
    }

    public function getMethod(): string{
        return $this->method;
    }

    public function getRouter(): string{
        return $this->router;
    }
}