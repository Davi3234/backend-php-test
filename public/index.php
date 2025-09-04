<?php

use Core\Exception\HttpException;
use Core\Server\Request;
use Core\Server\Response;


require __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../bin/bootstrap.php';


header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
  http_response_code(200);
  exit;
}

$response = new Response();

try {
  $routes = require __DIR__ . '/routes.php';

  $request = Request::fromGlobals();
  $metodoHttp = $request->getMethod();
  $uri = $request->getRouter();
  $params = $request->getParams();

  if (!isset($routes[$metodoHttp])) {
    throw new HttpException(405, ['Rota não suportada para este método']);
  }

  $found = null;
  $routeParams = [];

  foreach ($routes[$metodoHttp] as $route => $config) {
    $pattern = preg_replace('#\{[a-zA-Z_]+\}#', '([a-zA-Z0-9_-]+)', $route);
    $pattern = "#^" . $pattern . "$#";

    if (preg_match($pattern, $uri, $matches)) {
      array_shift($matches);

      preg_match_all('#\{([a-zA-Z_]+)\}#', $route, $paramNames);
      $routeParams = array_combine($paramNames[1], $matches);

      $found = $config;
      break;
    }
  }

  if (!$found) {
    throw new HttpException(404, ['Rota não encontrada']);
  }

  $controller = new $found['controller']();
  $action = $found['action'];

  if (!method_exists($controller, $action)) {
    throw new HttpException(500, ["Método {$action} não encontrado"]);
  }

  $allParams = array_merge($params, $routeParams);

  $result = $controller->$action($allParams);

  $response->setSuccess($result);

  echo $response->toJson();

} 
catch (HttpException $e) {
  $response->setError($e->getErrors(), $e->getCode());

  echo $response->toJson();
}
catch(Exception $e){
  $response->setError(['Ocorreu algum erro Interno', 500]);
}