<?php
class HttpRequest
{

  private $url;
  private $method;
  private $params;
  private $route;

  public function __construct($url = null, $method = null)
  {
    $this->url = is_null($url) ? $_SERVER["REQUEST_URI"] : $url;
    $this->method = is_null($method) ? $_SERVER["REQUEST_METHOD"] : $method;
    $this->params = [];
  }

  public function getFullDetails()
  {
    return [
      'url' => $this->url,
      'method' => $this->method,
      'params' => $this->params,
      'route' => $this->route,
      'ip' => $_SERVER['REMOTE_ADDR'],
      'user_agent' => $_SERVER['HTTP_USER_AGENT'],
      'referer' => $_SERVER['HTTP_REFERER'],
      'host' => $_SERVER['HTTP_HOST'],
      'protocol' => $_SERVER['REQUEST_SCHEME'],
      'port' => $_SERVER['SERVER_PORT'],
      'path' => $_SERVER['REQUEST_URI'],
      'query' => $_SERVER['QUERY_STRING'],
      'body' => file_get_contents('php://input'),
    ];
  }
  public function getUrl()
  {
    return $this->url;
  }

  public function getMethod()
  {
    return $this->method;
  }

  public function getParams()
  {
    return $this->params;
  }

  public function addParam($value)
  {
    $this->params[] = $value;
  }

  public function getRoute()
  {
    return $this->route;
  }

  public function setRoute($route)
  {
    $this->route = $route;
  }

  public function getParamsUrl()
  {
    $urlPath = $this->url;
    $routePath = $this->route->getPath();

    $urlPath = ltrim($urlPath, '/');
    $routePath = ltrim($routePath, '/');

    $urlParts = $urlPath ? explode('/', $urlPath) : [];
    $routeParts = $routePath ? explode('/', $routePath) : [];

    foreach ($routeParts as $index => $routePart) {
      if (strpos($routePart, ':') === 0) {
        $paramName = substr($routePart, 1);
        if (isset($urlParts[$index])) {
          $paramValue = $urlParts[$index];
          if (strpos($paramValue, ':') === 0) {
            $paramValue = substr($paramValue, 1);
          }
          $this->params[$paramName] = $paramValue;
        }
      }
    }

    foreach ($this->route->getParams() as $param) {
      if (isset($_GET[$param])) {
        $this->params[$param] = $_GET[$param];
      }
    }
  }

  public function bindParam()
  {
    switch ($this->method) {
      case "GET":
      case "DELETE":
        $this->getParamsUrl();
        break;
      case "PUT":
      case "POST":
        $jsonInput = file_get_contents("php://input");
        $postData = json_decode($jsonInput, true);
        if ($postData) {
          $this->params = $postData;
        }
        $this->getParamsUrl();
        break;
    }
  }

  public function run($config)
  {
    $this->bindParam();
    $this->route->run($this, $config);
  }
}
