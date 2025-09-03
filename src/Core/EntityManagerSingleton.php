<?php

namespace Core;

use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;

class EntityManagerSingleton{
  private static ?EntityManager $instance = null;

  private function __construct(){
  }

  public static function getInstance(): EntityManager{
    if (self::$instance === null) {
      $config = ORMSetup::createAttributeMetadataConfiguration(
        [__DIR__ . "/../src/Model"],
        true
      );

      $conn = [
        'driver' => $_ENV['DB_DRIVER'],
        'host' => $_ENV['DB_HOST'],
        'port' => $_ENV['DB_PORT'],
        'user' => $_ENV['DB_USER'],
        'password' => $_ENV['DB_PASS'],
        'dbname' => $_ENV['DB_NAME']
      ];

      $connection = DriverManager::getConnection($conn, $config);

      self::$instance = new EntityManager($connection, $config);
    }

    return self::$instance;
  }
}
