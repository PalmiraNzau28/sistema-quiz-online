<?php
// backend/models/Answer.php

require_once __DIR__ . '/../config/database.php';

class Answer {
    private $conn;
    private $table = "answers";

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function create($question_id, $answer_text, $is_correct = false, $answer_text_en = '') {
        if (empty(trim($answer_text))) {
            return ["success" => false, "message" => "O texto da resposta é obrigatório"];
        }
        
        $answer_text_en = $answer_text_en ?: $answer_text;
        
        $query = "INSERT INTO " . $this->table . " (question_id, answer_text, answer_text_en, is_correct) 
                  VALUES (:question_id, :answer_text, :answer_text_en, :is_correct)";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":question_id", $question_id);
        $stmt->bindParam(":answer_text", $answer_text);
        $stmt->bindParam(":answer_text_en", $answer_text_en);
        $stmt->bindParam(":is_correct", $is_correct, PDO::PARAM_BOOL);
        
        if ($stmt->execute()) {
            return ["success" => true, "message" => "Resposta criada com sucesso", "answer_id" => $this->conn->lastInsertId()];
        }
        
        return ["success" => false, "message" => "Erro ao criar resposta"];
    }

    public function getByQuestionId($question_id) {
        $query = "SELECT * FROM " . $this->table . " WHERE question_id = :question_id ORDER BY id ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":question_id", $question_id);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCorrectAnswer($question_id) {
        $query = "SELECT id, answer_text FROM " . $this->table . " WHERE question_id = :question_id AND is_correct = 1 LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":question_id", $question_id);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
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

    public function update($id, $answer_text, $is_correct, $answer_text_en = '') {
        if (empty(trim($answer_text))) {
            return ["success" => false, "message" => "O texto da resposta é obrigatório"];
        }
        
        $answer_text_en = $answer_text_en ?: $answer_text;
        
        $query = "UPDATE " . $this->table . " 
                  SET answer_text = :answer_text, answer_text_en = :answer_text_en, is_correct = :is_correct 
                  WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":answer_text", $answer_text);
        $stmt->bindParam(":answer_text_en", $answer_text_en);
        $stmt->bindParam(":is_correct", $is_correct, PDO::PARAM_BOOL);
        $stmt->bindParam(":id", $id);
        
        if ($stmt->execute()) {
            return ["success" => true, "message" => "Resposta atualizada com sucesso"];
        }
        
        return ["success" => false, "message" => "Erro ao atualizar resposta"];
    }

    public function delete($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        
        if ($stmt->execute()) {
            return ["success" => true, "message" => "Resposta apagada com sucesso"];
        }
        
        return ["success" => false, "message" => "Erro ao apagar resposta"];
    }
}
?>