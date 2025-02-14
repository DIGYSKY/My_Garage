<?php

class Router
{

  private $listRoutes;

  public function __construct()
  {
    if (!file_exists("src/routes/routes.json")) {
      exit;
    }
    $stringRoutes = file_get_contents("src/routes/routes.json");
    $this->listRoutes = json_decode($stringRoutes);
  }

  public function findRoute($httpRequest, $basepath)
  {
    $url = str_replace($basepath, "", $httpRequest->getUrl());
    $method = $httpRequest->getMethod();

    $routeFound = array_filter($this->listRoutes, function ($route) use ($url, $method) {
      // Séparer l'URL et la route en segments
      $urlParts = explode('/', trim($url, '/'));
      $routeParts = explode('/', trim($route->path, '/'));

      // Vérifier si le nombre de segments correspond
      if (count($urlParts) !== count($routeParts)) {
        return false;
      }

      // Vérifier chaque segment
      for ($i = 0; $i < count($urlParts); $i++) {
        // Si le segment de route commence par ':' et le segment d'URL aussi
        if (strpos($routeParts[$i], ':') === 0 && strpos($urlParts[$i], ':') === 0) {
          continue; // C'est un paramètre, on continue
        }
        // Sinon les segments doivent correspondre exactement
        if ($routeParts[$i] !== $urlParts[$i]) {
          return false;
        }
      }

      return $route->method === $method;
    });

    $numberRoute = count($routeFound);
    if ($numberRoute > 1) {
      $logger = new Logs();
      $logger->error("Routes multiples détectées.");
      throw new Exception("Routes multiples détectées.");
    } else if ($numberRoute === 0) {
      $logger = new Logs();
      $logger->error("Aucune route existante.");
      throw new Exception("Aucune route existante.");
    } else {
      return new Route(array_shift($routeFound));
    }
  }
}
