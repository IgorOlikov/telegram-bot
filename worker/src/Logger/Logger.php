<?php

namespace App\Logger;

abstract class Logger
{
    abstract public function write(string $data): void;


}