<?php
// backend/models/Question.php

require_once __DIR__ . '/../config/database.php';

class Question {
    private $conn;
    private $table = "questions";

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function create($quiz_id, $question_text, $question_type = 'multiple_choice', $question_text_en = '') {
        if (empty(trim($question_text))) {
            return ["success" => false, "message" => "O texto da pergunta é obrigatório"];
        }
        
        $question_text_en = $question_text_en ?: $question_text;
        
        $query = "INSERT INTO " . $this->table . " (quiz_id, question_text, question_text_en, question_type) 
                  VALUES (:quiz_id, :question_text, :question_text_en, :question_type)";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":quiz_id", $quiz_id);
        $stmt->bindParam(":question_text", $question_text);
        $stmt->bindParam(":question_text_en", $question_text_en);
        $stmt->bindParam(":question_type", $question_type);
        
        if ($stmt->execute()) {
            return ["success" => true, "message" => "Pergunta criada com sucesso", "question_id" => $this->conn->lastInsertId()];
        }
        
        return ["success" => false, "message" => "Erro ao criar pergunta"];
    }

    public function getByQuizId($quiz_id) {
        $query = "SELECT * FROM " . $this->table . " WHERE quiz_id = :quiz_id ORDER BY id ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":quiz_id", $quiz_id);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        
        if ($stmt->rowCount() === 0) {
            return null;
        }
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $question_text, $question_type = 'multiple_choice', $question_text_en = '') {
        if (empty(trim($question_text))) {
            return ["success" => false, "message" => "O texto da pergunta é obrigatório"];
        }
        
        $question_text_en = $question_text_en ?: $question_text;
        
        $query = "UPDATE " . $this->table . " 
                  SET question_text = :question_text, question_text_en = :question_text_en, question_type = :question_type 
                  WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":question_text", $question_text);
        $stmt->bindParam(":question_text_en", $question_text_en);
        $stmt->bindParam(":question_type", $question_type);
        $stmt->bindParam(":id", $id);
        
        if ($stmt->execute()) {
            return ["success" => true, "message" => "Pergunta atualizada com sucesso"];
        }
        
        return ["success" => false, "message" => "Erro ao atualizar pergunta"];
    }

    public function delete($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        
        if ($stmt->execute()) {
            return ["success" => true, "message" => "Pergunta apagada com sucesso"];
        }
        
        return ["success" => false, "message" => "Erro ao apagar pergunta"];
    }
}
?>