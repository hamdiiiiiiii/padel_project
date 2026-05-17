<?php
require_once __DIR__ . '/../core/Model.php';

class Venue extends Model
{
    public function getAll(): array
    {
        $stmt = $this->query('SELECT * FROM venues ORDER BY id DESC');
        return $stmt->fetchAll();
    }

    public function find(int $id): array|false
    {
        $stmt = $this->query('SELECT * FROM venues WHERE id = :id LIMIT 1', [
            'id' => $id,
        ]);

        return $stmt->fetch();
    }
}
