<?php

namespace App\Logger;

class HttpRequestLogger extends Logger
{

    public function write(string $data): void
    {
        $file = __DIR__ . '/../../../log/request_error.log';

        $stream = fopen($file, 'a', true);
        fwrite($stream, $data . "\n");
        fclose($stream);
    }
}