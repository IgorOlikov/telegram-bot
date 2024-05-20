<?php

declare(strict_types=1);


use Slim\App;
use function App\env;


return static function (App $app): void {
    $app->addBodyParsingMiddleware();
    $app->addErrorMiddleware((bool)env('APP_DEBUG'),true,true);
};