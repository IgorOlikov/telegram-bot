<?php


use Psr\Container\ContainerInterface;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\RunningMode\Webhook;
use function DI\create;
use function App\env;

return [


    Webhook::class => create(Webhook::class)->constructor(secretToken: $_ENV['TELEGRAM_SECRET_TOKEN']),


    //Nutgram::class => create(Nutgram::class)
    //    ->constructor(token: env('TELEGRAM_BOT_API_TOKEN')),


     Nutgram::class => static function (ContainerInterface $container) {

            /* @var Webhook $webhook */
            $webhook = $container->get(Webhook::class);

            //$webhook->setSafeMode(true);

            $bot = new Nutgram(token: env('TELEGRAM_BOT_API_TOKEN'));

            $bot->setRunningMode($webhook);

            return $bot;
     },


];