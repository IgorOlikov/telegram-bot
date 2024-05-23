<?php

use App\Logger\HttpRequestLogger;
use App\SomeClass;
use Bunny\Channel;
use Bunny\Message;
use Workerman\Psr7\Response;
use Workerman\Worker;
use Workerman\RabbitMQ\Client;

require __DIR__ . '/vendor/autoload.php';


sleep(mt_rand(10,15));

$worker = new Worker();

Worker::$stdoutFile =  __DIR__ . '/log/worker.log';

$pdo = new PDO("pgsql:dbname=".getenv('POSTGRES_DB').";host=".getenv('POSTGRES_HOST'),
    getenv('POSTGRES_USER'),
    getenv('POSTGRES_PASSWORD'));

$worker->onWorkerStart = function() {

    (new Client(['host' => 'rabbitmq',
        'port' => 5672,
        'user' => getenv('RABBITMQ_DEFAULT_USER'),
        'password' => getenv('RABBITMQ_DEFAULT_PASS')
    ]))->connect()
        ->then(function (Client $client) {
            return $client->channel();
        })
        ->then(function (Channel $channel) {
            echo ' [*] Waiting for messages', "\n";
            $channel->consume(
                function (Message $message, Channel $channel, Client $client) {

                    $messageArr = json_decode($message->content,true);

                    global $pdo;

                    echo "Message Received !!!", $message->content, "\n";

                    $cls = new SomeClass($message->content);


                    (new Workerman\Http\Client())->
                    post('https://api.telegram.org/bot' . getenv('TELEGRAM_BOT_API_TOKEN') . '/sendMessage', $messageArr,
                        function (Response $response) use ($messageArr, $message, $pdo) {

                            echo 'Сообщение с телом = ' . $message->content . ' Отправлено!' . "\n";

                    }, function (Response $response) use ($message, $messageArr) {

                            (new HttpRequestLogger())
                                ->write(json_encode([
                                    'status_code' => $response->getStatusCode(),
                                    'response_content' => $response->getBody()->getContents(),
                                    'text' => $messageArr['text'],
                                    'chat_id' => $messageArr['chat_id'],
                                ]));
                    });


                }, 'tg_search_messages', '', false, true);
    });
};

Worker::runAll();
