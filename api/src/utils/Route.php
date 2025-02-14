<?php
class Route
{
  private $path;
  private $controller;
  private $action;
  private $method;
  private $params;
  private $manager;

  public function __construct($route)
  {
    $this->path = $route->path;
    $this->controller = $route->controller;
    $this->action = $route->action;
    $this->method = $route->method;
    $this->params = $route->params;
    $this->manager = $route->manager;
  }

  public function getPath()
  {
    return $this->path;
  }

  public function getController()
  {
    return $this->controller;
  }

  public function getAction()
  {
    return $this->action;
  }

  public function getMethod()
  {
    return $this->method;
  }

  public function getParams()
  {
    return $this->params;
  }

  public function getManager()
  {
    return $this->manager;
  }

  public function checkParams($params)
  {
    foreach ($this->params as $param) {
      // Si le paramètre est dans l'URL (commence par ':'), on le skip
      if (strpos($this->path, ':' . $param) !== false) {
        continue;
      }

      if (strpos($param, '.') !== false) {
        $keys = explode('.', $param);
        $value = $params;
        foreach ($keys as $key) {
          if (!isset($value[$key])) {
            $logger = new Logs();
            $logger->error("Le paramètre {$param} est manquant.");
            throw new Exception("Le paramètre {$param} est manquant.");
          }
          $value = $value[$key];
        }
      } else {
        if (!isset($params[$param])) {
          $logger = new Logs();
          $logger->error("Le paramètre {$param} est manquant.");
          throw new Exception("Le paramètre {$param} est manquant.");
        }
      }
    }
  }

  public function run($httpRequest, $config)
  {
    $controller = null;
    $controllerName = "{$this->controller}Controller";
    if (class_exists($controllerName)) {
      $controller = new $controllerName($httpRequest, $config);
      if (method_exists($controller, $this->action)) {
        $params = $httpRequest->getParams();
        $this->checkParams($params);
        call_user_func([$controller, $this->action], $params);
      } else {
        $logger = new Logs();
        $logger->error("La méthode {$this->action} n'existe pas.");
        throw new Exception("La méthode n'existe pas.");
      }
    } else {
      $logger = new Logs();
      $logger->error("La classe {$controllerName} n'existe pas.");
      throw new Exception("La classe n'existe pas.");
    }
  }
}
