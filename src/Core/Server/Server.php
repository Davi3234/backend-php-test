<?php

namespace Core\Server;

use Core\Enum\MethodHTTP;
use Core\RouteAttributeBuilder;

class Server{
    private Request $request;
    private Response $response;

    /** @var array{controller: string, method: string}[] */
    private array $handlers = [];

    protected function __construct(){
        $this->request = Request::fromGlobals();
        $this->response = new Response();
    }

    public static function Bootstrap(){
        return new static();
    }

    function dispatch(){
        try {
            if ($this->request->getMethod() != MethodHTTP::OPTIONS->value) {
                $this->loadParamsRequest();
                $this->resolveHandlers();
            } else {
                $this->response->setSuccess();
            }
        } catch (\Exception $err) {
            $this->response->setError($err);
        }

        $this->sendResponse();
    }

    private function loadParamsRequest(): void{
        $requestData = [];

        switch ($this->request->getMethod()) {
            case MethodHTTP::GET->value:
                $requestData = $_GET;
                break;
            case MethodHTTP::POST->value:
            case MethodHTTP::PUT->value:
            case MethodHTTP::PATCH->value:
            case MethodHTTP::DELETE->value:
                $input = file_get_contents('php://input');
                $data = json_decode($input, true);
                $requestData = $data ?? $_POST;
                break;
        }

        $this->request = new Request($this->request->getRouter(), $this->request->getMethod(), $requestData);
    }

    private function resolveHandlers(): void{
        $routeBuilder = new RouteAttributeBuilder();
        $this->handlers = $routeBuilder->perform();

        $this->dispatchHandler();
    }

    private function dispatchHandler(): void{
        $found = null;
        $routeParams = [];

        foreach ($this->handlers as $handler) {
            if ($handler['method'] !== $this->request->getMethod()) {
                continue;
            }

            if (preg_match($handler['regex'], $this->request->getRouter(), $matches)) {
                $found = $handler;
                foreach ($matches as $key => $value) {
                    if (!is_int($key)) {
                        $routeParams[$key] = $value;
                    }
                }
                break;
            }
        }

        if (!$found) {
            $this->response->setStatus(404, 'Endpoint not found');
            return;
        }

        $controllerClass = $found['controller'];
        $method = $found['action'];
        $controller = new $controllerClass();

        $params = array_merge($this->request->getParams(), $routeParams);

        $result = $controller->$method($params);
        $this->response->setSuccess($result);
    }

    private function sendResponse(): void{
        header('Content-Type: application/json');
        http_response_code($this->response->getStatusCode());
        echo $this->response->toJson();
    }
}