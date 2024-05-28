<?php

namespace App\Http\Controllers;

use App\Database\Database;
use App\Repositories\ChatRepository;
use App\Repositories\RequestRepository;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use SergiX44\Nutgram\Nutgram;

class Webhook
{

   public function __construct(
       protected AMQPStreamConnection $rabbitmqConnection,
       protected Database $database,
       protected Nutgram $bot,
       protected ChatRepository $chatRepository,
       protected RequestRepository $requestRepository
   )
   {

   }


    public function __invoke(Request $request, Response $response): Response
    {

        $this->bot->onCommand('start', function(Nutgram $bot) {

            $bot->sendMessage('Здравстсвуйте. Введите запрос для поиска!');

            $user = $bot->user();

            $this
                ->chatRepository
                ->findOrCreate([
                    'id' => $user->id,
                    'username' => $user->username,
                    'first_name' => $user->first_name,
                    'last_name' => $user->last_name
                ]);
        });


        $this->bot->onMessage(function (Nutgram $bot) {


           //request validation !!!!!!!!!

           $bot->sendMessage('Ожидайте ваш запрос обрабатывается! Мы пришлём вам ответ в течение 1 минуты');

           $request = $this
               ->requestRepository
               ->create([
                   'chat_id' => $bot->chatId(),
                   'search_request' => $bot->message()->text,
               ]);

           $connection = $this->rabbitmqConnection;

           $channel = $connection->channel();

           $message = new AMQPMessage(json_encode([
               'request_id' => $request['id'],
               'chat_id' => $request['chat_id'],
               'text' => $request['search_request'],
               ]));

           $channel->basic_publish($message,'amq.direct','tg_search');

           $channel->close();
           $connection->close();


           // debug --------------
           $data = json_encode([
               'request_id' => $request['id'],
               'chat_id' => $request['chat_id'],
               'text' => $request['search_request'],
           ]);

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