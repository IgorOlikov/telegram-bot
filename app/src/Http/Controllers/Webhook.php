<?php

namespace App\Http\Controllers;

use App\Database\Database;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use SergiX44\Nutgram\Nutgram;

class Webhook extends BaseController
{

   public function __construct(
       protected AMQPStreamConnection $rabbitmqConnection,
       Database $database,
       protected Nutgram $bot
   )
   {
       parent::__construct($database);
   }


    public function __invoke(Request $request, Response $response): Response
    {
        //$pdo = $this->database->getPdo();




        /* bot logic */
        $this->bot->onCommand('start', function(Nutgram $bot) {
            $bot->sendMessage('Введите запрос для поиска!');
        });


        $this->bot->onMessage(function (Nutgram $bot) {

            $connection = $this->rabbitmqConnection;

            $channel = $connection->channel();


            $message = [
                'chat_id' => $bot->chatId(),
                'text' => $bot->message()->text,
            ];

            $message = new AMQPMessage(json_encode($message));

            $channel->basic_publish($message,'amq.direct','tg_search');

            $bot->sendMessage('Ожидайте ваш запрос обрабатывается! Мы пришлём вам ответ в течение 1 минуты');


            $channel->close();
            $connection->close();


            $data = json_encode(['user' => json_encode($bot->user()), 'chat_id' => $bot->chatId(), 'user_id' => $bot->userId()]);

            $path = __DIR__ . '/../../../var/telegram.log';

            $file = fopen($path, 'a',true);
            fwrite($file, $data . "\n");
            fclose($file);

        });


        $this->bot->run();

        $response->getBody()->write('True');

        return $response;
    }

}