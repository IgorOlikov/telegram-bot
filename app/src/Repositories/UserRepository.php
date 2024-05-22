<?php

namespace App\Repositories;

use App\Database\Database;
use PDO;

class UserRepository
{

    private PDO $pdo;

    public function __construct(private Database $database)
    {
        $this->pdo = $this->database->getPdo();
    }

    public function create()
    {
        $stmnt = $this->pdo->query('insert into users (id, username, first_name, last_name) values (:id, :username, :first_name, :last_name');


        $stmnt->bindValue()
    }

    public function findOrCreate()
    {
        //
    }

    public function findById()
    {
        //
    }

    public function all()
    {
        //
    }





}