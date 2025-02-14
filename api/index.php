<?php

ini_set("date.timezone", "Europe/Paris");

require_once "./src/utils/Autoloader.php";
Autoloader::register();

// Add CORS handling
CorsHandler::handleCors();

$configManager = new Config();
[$configFile, $config] = $configManager->registerConfig();

try {
  $httpRequest = new HttpRequest();
  $router = new Router();
  $httpRequest->setRoute($router->findRoute($httpRequest, $config->basepath));
  $httpRequest->run($config);
  $request = $httpRequest->getFullDetails();
  $logger = new Logs('requests/' . $httpRequest->getMethod() . '.log');
  $logger->logVariable($request, 'Request');
} catch (Exception $e) {
  $logger = new Logs();
  $logger->error($e->getMessage());
  throw new Exception($e->getMessage());
}
