<?php
// backend/models/Quiz.php

require_once __DIR__ . '/../config/database.php';

class Quiz {
    private $conn;
    private $table = "quizzes";

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Criar novo quiz
    public function create($title, $description, $created_by, $title_en = '', $description_en = '') {
        if (empty(trim($title))) {
            return ["success" => false, "message" => "O título é obrigatório"];
        }
        
        $title_en = $title_en ?: $title;
        $description_en = $description_en ?: $description;
        
        $query = "INSERT INTO " . $this->table . " (title, description, title_en, description_en, created_by) 
                  VALUES (:title, :description, :title_en, :description_en, :created_by)";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":title", $title);
        $stmt->bindParam(":description", $description);
        $stmt->bindParam(":title_en", $title_en);
        $stmt->bindParam(":description_en", $description_en);
        $stmt->bindParam(":created_by", $created_by);
        
        if ($stmt->execute()) {
            return ["success" => true, "message" => "Quiz criado com sucesso", "quiz_id" => $this->conn->lastInsertId()];
        }
        
        return ["success" => false, "message" => "Erro ao criar quiz"];
    }

    // Listar todos os quizzes (com campos para ambos idiomas)
    public function getAll() {
        $query = "SELECT q.*, u.name as author_name 
                  FROM " . $this->table . " q
                  JOIN users u ON q.created_by = u.id
                  ORDER BY q.created_at DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Buscar quiz por ID
    public function getById($id) {
        $query = "SELECT q.*, u.name as author_name 
                  FROM " . $this->table . " q
                  JOIN users u ON q.created_by = u.id
                  WHERE q.id = :id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        
        if ($stmt->rowCount() === 0) {
            return null;
        }
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Atualizar quiz
    public function update($id, $title, $description, $title_en = '', $description_en = '') {
        if (empty(trim($title))) {
            return ["success" => false, "message" => "O título é obrigatório"];
        }
        
        $title_en = $title_en ?: $title;
        $description_en = $description_en ?: $description;
        
        $query = "UPDATE " . $this->table . " 
                  SET title = :title, description = :description, 
                      title_en = :title_en, description_en = :description_en 
                  WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":title", $title);
        $stmt->bindParam(":description", $description);
        $stmt->bindParam(":title_en", $title_en);
        $stmt->bindParam(":description_en", $description_en);
        $stmt->bindParam(":id", $id);
        
        if ($stmt->execute()) {
            return ["success" => true, "message" => "Quiz atualizado com sucesso"];
        }
        
        return ["success" => false, "message" => "Erro ao atualizar quiz"];
    }

    // Apagar quiz
    public function delete($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        
        if ($stmt->execute()) {
            return ["success" => true, "message" => "Quiz apagado com sucesso"];
        }
        
        return ["success" => false, "message" => "Erro ao apagar quiz"];
    }
}
?>