<?php

namespace App\Http\Controllers;

use App\Repositories\ChatRepository;
use App\Repositories\RequestRepository;
use PDO;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;

class MainController
{

    public function __construct(private RequestRepository $requestRepository, private ChatRepository $chatRepository)
    {
    }


    public function index(Request $request, Response $response, App $app): Response
    {


        //dd($app->getContainer()->get('csrf'));



         $chat = $this->chatRepository->findOrCreate(['id' => 166, 'username' => 'rqweqwe', 'first_name' => 'adadad', 'last_name' => 'adad']);


         $request = $this
             ->requestRepository
             ->create([
                 'chat_id' => 166,
                 'search_request' => 'some text request',
             ]);


        $response->getBody()->write('hello');

        return $response;

    }


}