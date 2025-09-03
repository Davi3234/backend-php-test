<?php

use Core\EntityManagerSingleton;
use Dotenv\Dotenv;
require_once "vendor/autoload.php";

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$isDevMode = true;

$entityManager = EntityManagerSingleton::getInstance();