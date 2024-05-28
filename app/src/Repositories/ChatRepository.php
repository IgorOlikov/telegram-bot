<?php

namespace App\Repositories;

use App\Database\Database;
use PDO;

class ChatRepository
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
        $sql = 'insert into chats (id, username, first_name, last_name) values (:id, :username, :first_name, :last_name)';

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue(':id', (int)$data['id'], PDO::PARAM_INT);
        $stmt->bindValue(':username', $data['username']);
        $stmt->bindValue(':first_name', $data['first_name']);
        $stmt->bindValue(':last_name', $data['last_name']);

        $stmt->execute();

        return $this->findById((int)$data['id']);
    }

    public function findOrCreate(array $data): array
    {
        $chat = $this->findById($data['id']);

        if ($chat) {
            return $chat;
        }

        return $this->create($data);
    }

    public function findById(int $id): array|bool
    {
        $sql = 'select * from chats where id = :id';

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);

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

    public function getChatRequests(int $chatId): array
    {
        $sql = 'select *,sr.search_request from chats join search_requests sr on chats.id = sr.chat_id where chats.id = :chat_id';

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue(':chat_id', $chatId, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getChatResults(int $chatId): array
    {
        $sql = 'select *,sr.search_result from chats join search_results sr on chats.id = sr.chat_id where chats.id = :chat_id';

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue(':chat_id', $chatId, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }





}