<?php

require_once __DIR__ . '/../core/Model.php';

class User extends Model
{
    public function findByEmail(string $email): array|false
    {
        $stmt = $this->query('SELECT * FROM users WHERE email = :email LIMIT 1', [
            'email' => $email,
        ]);

        return $stmt->fetch();
    }

    public function create(array $data): bool
    {
        $sql = 'INSERT INTO users (name, email, password) VALUES (:name, :email, :password)';

        return $this->query($sql, [
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => password_hash($data['password'], PASSWORD_DEFAULT),
        ])->rowCount() > 0;
    }
}
