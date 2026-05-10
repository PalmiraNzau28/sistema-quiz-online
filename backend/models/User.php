<?php
// backend/models/User.php

require_once __DIR__ . '/../config/database.php';

class User {
    private $conn;
    private $table = "users";

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Validação de email (formato correto)
    private function validateEmail($email) {
        // Remove espaços
        $email = trim($email);
        
        // Verifica se está vazio
        if (empty($email)) {
            return ["valid" => false, "message" => "O email é obrigatório"];
        }
        
        // Verifica formato com filter_var (mais rigoroso)
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return ["valid" => false, "message" => "Email inválido. Exemplo válido: utilizador@dominio.com"];
        }
        
        // Verifica se não tem padrões como "palmira@.com"
        if (preg_match('/@\./', $email)) {
            return ["valid" => false, "message" => "Email inválido: domínio não pode estar vazio após o @"];
        }
        
        // Verifica se não termina com ponto
        if (substr($email, -1) === '.') {
            return ["valid" => false, "message" => "Email inválido: não pode terminar com ponto"];
        }
        
        return ["valid" => true, "message" => ""];
    }

    // Validação de password (forte)
    private function validatePassword($password) {
        $password = trim($password);
        
        if (empty($password)) {
            return ["valid" => false, "message" => "A palavra-passe é obrigatória"];
        }
        
        if (strlen($password) < 6) {
            return ["valid" => false, "message" => "A palavra-passe deve ter pelo menos 6 caracteres"];
        }
        
        if (strlen($password) > 50) {
            return ["valid" => false, "message" => "A palavra-passe não pode exceder 50 caracteres"];
        }
        
        // Pelo menos 1 letra maiúscula, 1 minúscula, 1 número
        if (!preg_match('/[A-Z]/', $password)) {
            return ["valid" => false, "message" => "A palavra-passe deve conter pelo menos uma letra maiúscula"];
        }
        
        if (!preg_match('/[a-z]/', $password)) {
            return ["valid" => false, "message" => "A palavra-passe deve conter pelo menos uma letra minúscula"];
        }
        
        if (!preg_match('/[0-9]/', $password)) {
            return ["valid" => false, "message" => "A palavra-passe deve conter pelo menos um número"];
        }
        
        return ["valid" => true, "message" => ""];
    }

    // Validação de nome
    private function validateName($name) {
        $name = trim($name);
        
        if (empty($name)) {
            return ["valid" => false, "message" => "O nome é obrigatório"];
        }
        
        if (strlen($name) < 2) {
            return ["valid" => false, "message" => "O nome deve ter pelo menos 2 caracteres"];
        }
        
        if (strlen($name) > 100) {
            return ["valid" => false, "message" => "O nome não pode exceder 100 caracteres"];
        }
        
        // Permite letras, espaços, acentos, hífen e apóstrofo
        if (!preg_match('/^[a-zA-ZÀ-ÿ\s\-\']+$/', $name)) {
            return ["valid" => false, "message" => "O nome pode conter apenas letras, espaços, hífen ou apóstrofo"];
        }
        
        return ["valid" => true, "message" => ""];
    }

    // Verificar se email já existe
    public function emailExists($email) {
        $query = "SELECT id FROM " . $this->table . " WHERE email = :email";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":email", $email);
        $stmt->execute();
        
        return $stmt->rowCount() > 0;
    }

    // Registar novo utilizador
    public function register($name, $email, $password, $user_type = 'user') {
        // Validações
        $nameValidation = $this->validateName($name);
        if (!$nameValidation['valid']) {
            return ["success" => false, "message" => $nameValidation['message']];
        }
        
        $emailValidation = $this->validateEmail($email);
        if (!$emailValidation['valid']) {
            return ["success" => false, "message" => $emailValidation['message']];
        }
        
        $passwordValidation = $this->validatePassword($password);
        if (!$passwordValidation['valid']) {
            return ["success" => false, "message" => $passwordValidation['message']];
        }
        
        // Verificar se email já existe
        if ($this->emailExists($email)) {
            return ["success" => false, "message" => "Este email já está registado"];
        }
        
        // Hash da password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        // Inserir utilizador
        $query = "INSERT INTO " . $this->table . " (name, email, password, user_type) 
                  VALUES (:name, :email, :password, :user_type)";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":password", $hashed_password);
        $stmt->bindParam(":user_type", $user_type);
        
        if ($stmt->execute()) {
            return ["success" => true, "message" => "Utilizador registado com sucesso", "user_id" => $this->conn->lastInsertId()];
        }
        
        return ["success" => false, "message" => "Erro ao registar utilizador"];
    }

    // Login
    public function login($email, $password) {
        // Validação de email
        $emailValidation = $this->validateEmail($email);
        if (!$emailValidation['valid']) {
            return ["success" => false, "message" => $emailValidation['message']];
        }
        
        // Validação de password (apenas verificar se não está vazia)
        if (empty(trim($password))) {
            return ["success" => false, "message" => "A palavra-passe é obrigatória"];
        }
        
        // Buscar utilizador
        $query = "SELECT id, name, email, password, user_type FROM " . $this->table . " WHERE email = :email";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":email", $email);
        $stmt->execute();
        
        if ($stmt->rowCount() === 0) {
            return ["success" => false, "message" => "Email ou palavra-passe incorretos"];
        }
        
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Verificar password
        if (!password_verify($password, $user['password'])) {
            return ["success" => false, "message" => "Email ou palavra-passe incorretos"];
        }
        
        return [
            "success" => true, 
            "message" => "Login bem-sucedido",
            "user" => [
                "id" => $user['id'],
                "name" => $user['name'],
                "email" => $user['email'],
                "user_type" => $user['user_type']
            ]
        ];
    }

    // Buscar utilizador por ID
    public function findById($id) {
        $query = "SELECT id, name, email, user_type, created_at FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        
        if ($stmt->rowCount() === 0) {
            return null;
        }
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Buscar utilizador por email
    public function findByEmail($email) {
        $query = "SELECT id, name, email, user_type, created_at FROM " . $this->table . " WHERE email = :email";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":email", $email);
        $stmt->execute();
        
        if ($stmt->rowCount() === 0) {
            return null;
        }
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Gerar token para reset de password
    public function generateResetToken($email) {
        $emailValidation = $this->validateEmail($email);
        if (!$emailValidation['valid']) {
            return ["success" => false, "message" => $emailValidation['message']];
        }
        
        $user = $this->findByEmail($email);
        if (!$user) {
            return ["success" => false, "message" => "Email não encontrado"];
        }
        
        $token = bin2hex(random_bytes(32));
        $expiry = date('Y-m-d H:i:s', strtotime('+1 hour'));
        
        $query = "UPDATE " . $this->table . " SET reset_token = :token WHERE email = :email";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":token", $token);
        $stmt->bindParam(":email", $email);
        
        if ($stmt->execute()) {
            return ["success" => true, "token" => $token, "expiry" => $expiry];
        }
        
        return ["success" => false, "message" => "Erro ao gerar token"];
    }

    // Reset password com token
    public function resetPassword($token, $new_password) {
        $passwordValidation = $this->validatePassword($new_password);
        if (!$passwordValidation['valid']) {
            return ["success" => false, "message" => $passwordValidation['message']];
        }
        
        // Verificar se token existe
        $query = "SELECT id FROM " . $this->table . " WHERE reset_token = :token";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":token", $token);
        $stmt->execute();
        
        if ($stmt->rowCount() === 0) {
            return ["success" => false, "message" => "Token inválido ou expirado"];
        }
        
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        
        $query = "UPDATE " . $this->table . " SET password = :password, reset_token = NULL WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":password", $hashed_password);
        $stmt->bindParam(":id", $user['id']);
        
        if ($stmt->execute()) {
            return ["success" => true, "message" => "Palavra-passe redefinida com sucesso"];
        }
        
        return ["success" => false, "message" => "Erro ao redefinir palavra-passe"];
    }
}
?>