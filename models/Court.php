<?php

require_once __DIR__ . '/../core/Model.php';

class Court extends Model
{
    public function getAll(): array
    {
        // Matches your new column: 'id'
        $stmt = $this->query('SELECT * FROM courts ORDER BY id DESC');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find(int $id): array|false
    {
        // Matches your new column: 'id'
        $stmt = $this->query('SELECT * FROM courts WHERE id = :id LIMIT 1', [
            'id' => $id,
        ]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}