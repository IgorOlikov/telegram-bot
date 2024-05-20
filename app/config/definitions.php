<?php


use Laminas\ConfigAggregator\ConfigAggregator;
use Laminas\ConfigAggregator\PhpFileProvider;

$aggregator = new ConfigAggregator([
   new PhpFileProvider(__DIR__ . '/definitions/*.php')
]);

return $aggregator->getMergedConfig();