<?php

use Dotenv\Dotenv;
use Psr\Container\ContainerInterface;

use Slim\App;
use function App\env;


require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();




/* @var ContainerInterface $container */
$container = require __DIR__ . '/../config/container.php';

/*  @var App $app */
$app = (require __DIR__ . '/../config/app.php')($container);

$app->run();
