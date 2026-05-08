<?php
class Database {
    private static $instance = null;
    private $connection;

    private $host = 'localhost';
    private $user = 'root';
    private $pass = '';
    private $name = 'padel_db';

    private function __construct() {
        try {
            $this->connection = new PDO("mysql:host={$this->host};dbname={$this->name};charset=utf8", $this->user, $this->pass);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    public static function getInstance() {
        if(!self::$instance) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->connection;
    }
}