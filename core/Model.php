<?php

require_once __DIR__ . '/Database.php';

class Model
{
    protected PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    // This is your core query runner
    protected function query(string $sql, array $params = []): PDOStatement
    {
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    /**
     * Helper to get everything from a table.
     * We pass $pk (Primary Key) to avoid the "Unknown column 'id'" error.
     */
    public function all(string $table, string $pk = 'id'): array
    {
        // Now it will use 'court_id' instead of 'id' if we tell it to!
        $sql = "SELECT * FROM {$table} ORDER BY {$pk} DESC";
        return $this->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }
}