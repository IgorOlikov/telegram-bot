<?php

namespace App;

class SomeClass
{
    public string $string;

    public function __construct(string $string)
    {
        $this->string = $string;
    }

    public function getString(): string
    {
        return $this->string;
    }

}