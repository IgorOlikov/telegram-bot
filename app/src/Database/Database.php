<?php

namespace App\Database;

use PDO;

readonly class Database
{
    public function __construct(public PDO $pdo)
    {
    }

    public function getPdo(): PDO
    {
        return $this->pdo;
    }


}