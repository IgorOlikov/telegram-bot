<?php


use App\Database\Database;
use Psr\Container\ContainerInterface;
use function App\env;


$dsn = sprintf('pgsql:host=%s;dbname=%s', ...[env('POSTGRES_HOST'), env('POSTGRES_DB')]);


return [

    PDO::class => DI\create(PDO::class)
        ->constructor(
            dsn: $dsn,
            username: env('POSTGRES_USER'),
            password: env('POSTGRES_PASSWORD'),
            options: [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_EMULATE_PREPARES => false]
        ),

    //Database::class => function (ContainerInterface $container) {
    //    $pdo = $container->get(PDO::class);
//
    //    return new Database($pdo);
    //}




];