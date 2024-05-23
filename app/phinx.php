<?php

use Slim\App;
use function App\env;

/* @var App $app */
$app = require __DIR__ . '/bin/App.php';

$pdoInstance = $app->getContainer()->get(PDO::class);

return
[
    'paths' => [
        'migrations' => '%%PHINX_CONFIG_DIR%%/db/migrations',
        'seeds' => '%%PHINX_CONFIG_DIR%%/db/seeds'
    ],
    'environments' => [
        'default_migration_table' => 'phinxlog',
        'default_environment' => 'development',
        'production' => [
            'adapter' => 'mysql',
            'host' => 'localhost',
            'name' => 'production_db',
            'user' => 'root',
            'pass' => '',
            'port' => '3306',
            'charset' => 'utf8',
        ],
        'development' => [
            'name' => 'app',
            'connection' => $pdoInstance,
            //'name' => env('POSTGRES_DB'),
            //'adapter' => 'pgsql',
            //'host' => env('POSTGRES_HOST'),
            //'user' => env('POSTGRES_USER'),
            //'pass' => env('POSTGRES_PASSWORD'),
            //'port' => '5432',
            //'charset' => 'utf8',
        ],
        'testing' => [
            'adapter' => 'mysql',
            'host' => 'localhost',
            'name' => 'testing_db',
            'user' => 'root',
            'pass' => '',
            'port' => '3306',
            'charset' => 'utf8',
        ]
    ],
    'version_order' => 'creation'
];
