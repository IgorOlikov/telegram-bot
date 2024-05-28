<?php

namespace App\Repositories;

use App\Database\Database;
use PDO;

class RequestRepository
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
        $sql = 'insert into search_requests (chat_id, search_request) values (:chat_id, :search_request)';

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue(':chat_id', (int)$data['chat_id'], PDO::PARAM_INT);
        $stmt->bindValue(':search_request', $data['search_request']);

        $stmt->execute();

        $id = (int)$this->pdo->lastInsertId();

        return $this->findById($id);
    }

    public function findById(int $id): array
    {
        $sql = 'select * from search_requests where id = :id';

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function all(): array
    {
        $sql = 'select * from search_requests';

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    public function getResult(int $requestId): array
    {
        $sql = 'select *,res.search_result from search_requests req join search_results res on req.id = res.search_request_id where req.id = :requestId';

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }






}