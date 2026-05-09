<?php

require_once __DIR__ . '/../core/Model.php';

class Court extends Model
{
    public function getAll(): array
    {
        $stmt = $this->query('SELECT * FROM courts ORDER BY id DESC');
        return $stmt->fetchAll();
    }

    public function find(int $id): array|false
    {
        $stmt = $this->query('SELECT * FROM courts WHERE id = :id LIMIT 1', [
            'id' => $id,
        ]);

        return $stmt->fetch();
    }
}
