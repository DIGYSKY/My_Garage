<?php

class Autoloader{

  public static function register(){
    spl_autoload_register(function ($class){
      $configFile = file_get_contents("src/config/config.json");
      $config = json_decode($configFile);
      $class = ucfirst($class);
      foreach($config->autoloadFolder as $folder){
        if(file_exists("src/{$folder}/{$class}.php")){
          require_once "src/{$folder}/{$class}.php";
          break;
        }
      }
    });
  }

}