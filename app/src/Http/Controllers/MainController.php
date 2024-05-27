<?php

namespace App\Http\Controllers;

use PDO;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;

class MainController extends BaseController
{


    public function index(Request $request, Response $response, App $app): Response
    {


        //dd($app->getContainer()->get('csrf'));


        $response->getBody()->write('hello');

        return $response;

    }


}