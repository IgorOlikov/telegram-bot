<?php

namespace App\Repositories;

use App\Database\Database;
use PDO;

class ResultRepository
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
        $sql = 'insert into search_results (chat_id, search_request_id, search_result) values (:chat_id, :search_request_id, :search_result)';

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue(':chat_id', (int)$data['chat_id'], PDO::PARAM_INT);
        $stmt->bindValue(':search_request_id', $data['search_request_id']);
        $stmt->bindValue(':search_result', $data['search_result']);

        $stmt->execute();

        return $this->findByRequestId((int)$data['search_request_id']);
    }


    public function findByRequestId(int $id): array
    {
        $sql = 'select * from search_results where search_request_id = :id';

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function all(): array
    {
        $sql = 'select * from search_results';

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getRequest(int $searchRequestId): array //belongs to
    {
        $sql = 'select * from search_results res join search_requests req on res.search_request_id = req.id where res.search_request_id = :searchRequestId';

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }





}