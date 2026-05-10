<?php
// backend/config/database.php

class Database {
    private $host = "localhost:3307";  // ← MUDADO para porta 3307
    private $db_name = "quiz_system";
    private $username = "root";
    private $password = "";  // ou a tua password se tiveres
    private $conn;

    public function getConnection() {
        $this->conn = null;

        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name,
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->exec("set names utf8");
        } catch(PDOException $e) {
            echo "Erro na conexão: " . $e->getMessage();
        }

        return $this->conn;
    }
}
?>