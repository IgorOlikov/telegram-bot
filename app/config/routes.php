<?php

use App\Http\Controllers\MainController;
use App\Http\Controllers\Webhook;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;

return static function (App $app): void {

    //web


    $app->get('/', [MainController::class, 'index']); //->add('csrf');


    //api

    $app->post('/webhook', Webhook::class);
};