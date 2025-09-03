<?php

namespace Core;

use Core\Http\Controller;
use Core\Http\Get;

class RouteAttributeBuilder{

    private static $HTTP_METHODS_ATTRIBUTES = [
        Get::class
    ];

    public function perform(){

        $routes = require __DIR__ . '/../../public/routes.php';
        $arrMap = [];

        foreach ($routes as $className) {
            if (!class_exists($className)) {
                continue;
            }

            $reflectionClass = new \ReflectionClass($className);

            $prefixes = $reflectionClass->getAttributes(Controller::class);

            $controllerInstance = $prefixes[0]->newInstance();

            $methods = $reflectionClass->getMethods();

            foreach ($methods as $method) {

                $endpointsAttributes = [];

                foreach (static::$HTTP_METHODS_ATTRIBUTES as $httpMethod) {
                    $endpointsAttributes = array_merge($endpointsAttributes, $method->getAttributes($httpMethod));
                }

                foreach ($endpointsAttributes as $endpointAttribute) {
                    $httpMethodInstance = $endpointAttribute->newInstance();

                    $arrMap[] = [
                        'path' => $controllerInstance->prefix . $httpMethodInstance->path,
                        'regex' => $this->convertPathToRegex($controllerInstance->prefix . $httpMethodInstance->path),
                        'method' => $httpMethodInstance->method,
                        'controller' => $className,
                        'action' => $method->getName()
                    ];
                }
            }

        }
        return $arrMap;
    }

    private function convertPathToRegex(string $path): string{
        return '#^' . preg_replace('/\{(\w+)\}/', '(?P<\1>[^/]+)', $path) . '$#';
    }
}