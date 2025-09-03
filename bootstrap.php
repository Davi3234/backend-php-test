<?php

use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\ORMSetup;
use Doctrine\ORM\EntityManager;
use Dotenv\Dotenv;
require_once "vendor/autoload.php";

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$isDevMode = true;

$config = ORMSetup::createAttributeMetadataConfiguration(
  paths: array(__DIR__ . "/src"), 
  isDevMode: $isDevMode
);

$conn = array(
  'driver' => $_ENV['DB_DRIVER'],
  'host' => $_ENV['DB_HOST'],
  'port' => $_ENV['DB_PORT'],
  'user' => $_ENV['DB_USER'],
  'password' => $_ENV['DB_PASS'],
  'dbname' => $_ENV['DB_NAME']
);

$connection = DriverManager::getConnection($conn, $config);

$entityManager = new EntityManager($connection, $config);