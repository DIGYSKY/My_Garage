<?php

class BDD
{
  private $bdd;
  private static $instance;

  public function __construct($bddConfig = null)
  {
    if (is_null($bddConfig)) {
      $configManager = new Config('src/config/config.json');
      $config = $configManager->getConfig()->database;
    } else {
      $config = $bddConfig;
    }

    try {
      $this->bdd = new PDO(
        "mysql:host={$config->host};port={$config->port};dbname={$config->database};charset=utf8mb4",
        $config->user,
        $config->password,
        [
          PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
          PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
          PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4",
          PDO::ATTR_PERSISTENT => true
        ]
      );
    } catch (PDOException $e) {
      $logger = new Logs();
      $logger->error("Erreur de connexion à la base de données : " . $e->getMessage());
      throw new Exception("Erreur de connexion à la base de données : " . $e->getMessage());
    }
  }

  public static function getInstance()
  {
    if (is_null(self::$instance)) {
      self::$instance = new self();
    }
    return self::$instance;
  }

  public function getBdd()
  {
    return $this->bdd;
  }
}
