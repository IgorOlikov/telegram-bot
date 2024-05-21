<?php

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
        'password' => getenv('RABBITMQ_DEFAULT_PASS')]))

        ->connect()

        ->then(function (Client $client) {
            return $client->channel();

        })
        ->then(function (Channel $channel) {

            return $channel->queueDeclare('tg_search_messages', false, true, false, false)

                ->then(function () use ($channel) {
                    return $channel;
            });
        })
        ->then(function (Channel $channel) {
            echo ' [*] Waiting for messages. To exit press CTRL+C', "\n";
            $channel->consume(
                function (Message $message, Channel $channel, Client $client) {

                    $messageArr = json_decode($message->content,true);

                    global $pdo;

                    echo "Message Received !!!", $message->content, "\n";

                    $cls = new SomeClass($message->content);

                    var_dump($pdo->pgsqlGetPid());


                    $http = new Workerman\Http\Client();

                    $http->post('https://api.telegram.org/bot' . getenv('TELEGRAM_BOT_API_TOKEN') . '/sendMessage', $messageArr,
                        function (Response $response) use ($messageArr, $message, $pdo) {


                            echo 'Сообщение с телом = ' . $message->content . ' Отправлено!';

                    }, function (Response $response) use ($message, $messageArr) {
                        $err = [];

                        $err['status_code'] = $response->getStatusCode();
                        $err['content'] = $response->getBody()->getContents();
                        $err['message_content'] = $messageArr['message'];
                        $err['message_chat_id'] = $messageArr['chat_id'];

                        $error = json_encode($err);

                        $file = __DIR__ . '/log/request_error.log';

                        $stream = fopen($file, 'a', true);
                        fwrite($stream, $error . "\n");
                        fclose($stream);
                  });


              }, 'tg_search_messages', '', false, true);

  });




};

Worker::runAll();
