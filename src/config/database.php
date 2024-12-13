<?php
// Database configuration
class Database {
    private $host = 'localhost';
    private $db = 'financial_records_db';
    private $user = 'root';
    private $pass = 'admin123';
    private $pdo;

    public function __construct() {
        try {
            $this->pdo = new PDO("mysql:host={$this->host};dbname={$this->db};charset=utf8", $this->user, $this->pass);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }
    }

    public function getConnection() {
        return $this->pdo;
    }
}

// Create a new Database instance
$database = new Database();
$pdo = $database->getConnection();
?>
