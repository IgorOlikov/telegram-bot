<?php


use PhpAmqpLib\Connection\AMQPStreamConnection;
use function App\env;
use function DI\create;

return [

  AMQPStreamConnection::class => create(AMQPStreamConnection::class)
      ->constructor(
          host: 'rabbitmq',
          port: 5672,
          user: env('RABBITMQ_DEFAULT_USER'),
          password: env('RABBITMQ_DEFAULT_PASS')
      ),

];