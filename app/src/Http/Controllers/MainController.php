<?php

namespace App\Http\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class MainController extends BaseController
{


    public function index(Request $request, Response $response): Response
    {

        $database = $this->database;

        $pdo = $database->getPdo();



        $response->getBody()->write('hello');

        return $response;

    }


}