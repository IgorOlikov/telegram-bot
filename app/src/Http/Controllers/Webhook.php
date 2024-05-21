<?php

namespace App\Http\Controllers;

use App\Database\Database;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use SergiX44\Nutgram\Nutgram;

class Webhook extends BaseController
{

   public function __construct(
       Database $database,
       protected Nutgram $bot
   )
   {
       parent::__construct($database);
   }


    public function handle(Request $request, Response $response): Response
    {
        //$pdo = $this->database->getPdo();


        $webhook = new \SergiX44\Nutgram\RunningMode\Webhook(secretToken: $_ENV['TELEGRAM_SECRET_TOKEN']);

        //$webhook->setSafeMode(true);

        $this->bot->setRunningMode($webhook);


        $this->bot->onCommand('start', function(Nutgram $bot) {
            $bot->sendMessage('Введите запрос для поиска!');
        });


        $this->bot->onMessage(function (Nutgram $bot) {


            $chatId = $bot->chatId();

            $bot->sendMessage('You sent a message!' . 'chatId' . $chatId);

            $user = $bot->user();

            $user = json_encode($user);

            $path = __DIR__ . '/../../../var/telegram.log';

            $file = fopen($path, 'a',true);
            fwrite($file, $user);
            fclose($file);


        });




        $this->bot->run();

        $response->getBody()->write('True');

        return $response;
    }

}