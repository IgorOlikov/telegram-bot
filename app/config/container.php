<?php

use DI\ContainerBuilder;

$builder = new ContainerBuilder();

$definitions = require_once __DIR__ . '/definitions.php';

$builder->addDefinitions($definitions);

$container = $builder->build();

return $container;