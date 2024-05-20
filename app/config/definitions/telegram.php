<?php


use SergiX44\Nutgram\Nutgram;
use function DI\create;

return [

    Nutgram::class => create(Nutgram::class)
        ->constructor(token: $_ENV['TELEGRAM_TOKEN']),


];