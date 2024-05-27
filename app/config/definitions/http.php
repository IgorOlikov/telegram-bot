<?php

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Slim\Csrf\Guard;
use Slim\Psr7\Factory\ResponseFactory;

return [

    ResponseFactoryInterface::class => static fn(): ResponseFactoryInterface => new ResponseFactory(),

    'csrf' =>  static function (ContainerInterface $container) {
        $responseFactory = $container->get(ResponseFactoryInterface::class);
        return new Guard($responseFactory);
  }


];