<?php

namespace App\Repositories;

use App\Database\Database;
use PDO;

class UserRepository
{

    private PDO $pdo;
    private Database $database;

    public function __construct(Database $database)
    {
        $this->database = $database;
        $this->pdo = $this->database->getPdo();
    }

    public function create(array $data): array
    {
        $sql = 'insert into users (email, name, password) values (:email, :name, :password)';

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue(':email', $data['email']);
        $stmt->bindValue(':name', $data['name']);
        $stmt->bindValue(':password', $data['password']);

        $stmt->execute();

        $id = (int)$this->pdo->lastInsertId();

        return $this->findById($id);
    }

    public function findOrCreate(array $data): array
    {
       $sql = 'select * from users where email = :email and name = :name';

       $stmt = $this->pdo->prepare($sql);

       $stmt->bindValue(':email', $data['email']);
       $stmt->bindValue(':name', $data['name']);

       $stmt->execute();

       $user = $stmt->fetch(PDO::FETCH_ASSOC);

       if ($user) {
           return $user;
       }

       return $this->create($data);
    }

    public function findById(int $id): array
    {
        $sql = 'select * from users where id = :id';

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function all(): array
    {
        $sql = 'select * from users';

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }





}